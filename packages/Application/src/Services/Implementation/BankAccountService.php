<?php

namespace Application\Services\Implementation;

use Application\Services\Interface\IBankAccountService;
use Domain\Enums\AccountType;
use Domain\Models\BankAccount;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Infrastructure\Repositories\BankAccountRepository;

class BankAccountService implements IBankAccountService
{

    public function __construct(private BankAccountRepository $bankAccountRepo) {}


    public function filterAccounts(array $filters): LengthAwarePaginator
    {
        return $this->bankAccountRepo->filter($filters);
    }


    public function getTransactions(BankAccount $bankAccount): Collection
    {
        return $this->bankAccountRepo->getTransactions($bankAccount);
    }


    public function createAccount(array $data): BankAccount
    {
        $maxAccountNumber = $this->bankAccountRepo->getMaxAccountNumber();
        $data['account_number'] = $maxAccountNumber ? $maxAccountNumber + 1 : 1000000000;
        $data['balance'] = 0;

        $bankAccount = $this->bankAccountRepo->create($data);

        if ($data['account_type'] == AccountType::CHECKING->value) {
            $this->createCardForAccount($bankAccount);
        }

        return $bankAccount;
    }


    public function deleteAccount(BankAccount $bankAccount): bool
    {
        if ($bankAccount->balance > 0) {
            return false;
        }

        return $this->bankAccountRepo->delete($bankAccount);
    }


    private function createCardForAccount(BankAccount $bankAccount): void
    {
        $cardNumber = $this->generateCardNumber();
        $cvv = rand(100, 999);
        $expireMonth = rand(1, 12);
        $expireYear = now()->addYears(3)->year;

        $this->bankAccountRepo->createCard($bankAccount, [
            'card_number' => $cardNumber,
            'cvv' => $cvv,
            'expire_month' => $expireMonth,
            'expire_year' => $expireYear,
            'is_active' => true,
        ]);
    }


    private function generateCardNumber(): string
    {
        $prefix = '5100'; // Prefix
        $lengthRandomPart = 12; // délka náhodné části čísla

        do {
            // Náhodná část s doplněním nul zleva
            $randomPart = str_pad((string) rand(0, 999_999_999_999), $lengthRandomPart, '0', STR_PAD_LEFT);

            $number = $prefix . $randomPart;

        } while ($this->bankAccountRepo->cardNumberExists($number));

        return $number;
    }

}
