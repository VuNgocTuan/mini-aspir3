<?php

namespace LoanModule\Repositories\LoanApplication;

use App\Repositories\RepositoryAbstract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use LoanModule\Exceptions\LoanApplicationAlreadyApplyException;
use LoanModule\Exceptions\LoanApplicationRepayNotAllowException;
use LoanModule\Exceptions\LoanClosedRepayNotAllowException;
use LoanModule\Models\LoanApplication;
use LoanModule\Models\LoanStatus;

class LoanApplicationRepository extends RepositoryAbstract implements LoanApplicationRepositoryInterface
{
    public function __construct(LoanApplication $model)
    {
        $this->model = $model;
    }

    public function isUserCanApply(int $userId): bool
    {
        $loanApplication = $this->findByField('user_id', $userId)
            ->where('status_id', LoanStatus::APPLICATION)
            ->orWhere('status_id', LoanStatus::OPEN)
            ->first();

        return !isset($loanApplication);
    }

    public function apply(int $userId, int $termByMonth, $amount): LoanApplication
    {
        $loanApplication = $this->store(
            [
                'user_id' => $userId,
                'status_id' => LoanStatus::APPLICATION,
                'amount' => $amount,
                'start_date' => now(),
                'end_date' => now()->addMonths($termByMonth),
                'term' => $termByMonth,
            ]
        );

        return $loanApplication->load('status');
    }

    public function get(int $userId, int $loanApplicationId): LoanApplication
    {
        $loanApplication = $this->findByFields([
            'id' => $loanApplicationId,
            'user_id' => $userId,
        ])->first();

        if (!$loanApplication) {
            throw new ModelNotFoundException();
        }

        return $loanApplication;
    }

    public function getLoanApplicationToRepay(int $userId, int $loanApplicationId): LoanApplication
    {
        $loanApplication = $this->get($userId, $loanApplicationId);
        $statusId = $loanApplication->status?->id;

        if ($statusId == LoanStatus::APPLICATION) {
            throw new LoanApplicationRepayNotAllowException();
        } elseif ($statusId == LoanStatus::CLOSED) {
            throw new LoanClosedRepayNotAllowException();
        }

        return $loanApplication->load('repays');
    }

    public function updateStatus(int $loanApplicationId, int $loanStatus): bool
    {
        return $this->findOrFail($loanApplicationId)->update([
            'status_id' => $loanStatus
        ]);
    }

    public function getList(?int $userId, ?int $status): Collection
    {
        return $this->with(['status', 'repays'])
            ->when($userId, function ($query) use ($userId) {
                return $query->where('user_id', $userId);
            })
            ->when($status, function ($query) use ($status) {
                return $query->where('status_id', $status);
            })
            ->get();
    }

    public function applyByBanker(int $bankUserId, int $loanApplicationId): bool
    {
        $loanApplication = $this->findOrFail($loanApplicationId);

        if (in_array($loanApplication->status_id, [LoanStatus::OPEN, LoanStatus::CLOSED])) {
            throw new LoanApplicationAlreadyApplyException();
        }

        return $loanApplication->update([
            'bank_user_id' => $bankUserId,
            'status_id' => LoanStatus::OPEN
        ]);
    }
}
