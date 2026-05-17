<?php

namespace App\Livewire\Services;

use App\Models\PaymentSlip;

class PaymentSlipServices
{
    public function all($userId)
    {
        return PaymentSlip::where('user_id', $userId)
            ->orWhere('advisor_id', $userId)
            ->latest()
            ->get();
    }

    public function store(array $data)
    {
        return PaymentSlip::create($data);
    }

    public function find($id)
    {
        return PaymentSlip::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $slip = PaymentSlip::findOrFail($id);

        $slip->update($data);

        return $slip;
    }

    public function delete($id)
    {
        return PaymentSlip::findOrFail($id)->delete();
    }

    public function approve($id)
    {
        return $this->update($id, [
            'status' => 'approved'
        ]);
    }

    public function reject($id)
    {
        return $this->update($id, [
            'status' => 'rejected'
        ]);
    }
}
