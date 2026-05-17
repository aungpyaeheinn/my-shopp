<?php

namespace App\Livewire\Component;

use App\Livewire\Services\PaymentSlipServices;
use App\Models\User;
use Livewire\Component;

class PaymentSlipComponent extends Component
{
    public string $title = '';

    public ?string $description = '';

    public ?int $advisor_id = null;

    public ?int $slip_id = null;

    public bool $isEdit = false;

    public bool $isCreate = false;

    public bool $isViewDetail = false;

    public ?object $viewingSlip = null;

    protected PaymentSlipServices $slipPaymentSlipServices;

    public function boot(
        PaymentSlipServices $paymentSlipServices
    ) {
        $this->slipPaymentSlipServices = $paymentSlipServices;
    }

    protected function rules()
    {
        return [
            'title' => 'required',
            'advisor_id' => 'required|exists:users,id',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function showCreateForm()
    {
        $this->isCreate = true;
    }

    public function cancelCreate()
    {
        $this->isCreate = false;
        $this->resetForm();
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store()
    {
        $this->validate();

        $this->slipPaymentSlipServices->store([
            'user_id' => auth()->id(),
            'advisor_id' => $this->advisor_id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => 'pending',
        ]);

        $this->resetForm();
        $this->isCreate = false;
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $slip = $this->slipPaymentSlipServices->find($id);

        abort_if(
            $slip->user_id !== auth()->id(),
            403
        );

        abort_if(
            $slip->status !== 'pending',
            403,
            'Cannot edit a form that has already been approved or rejected.'
        );

        $this->slip_id = $slip->id;
        $this->title = $slip->title;
        $this->description = $slip->description;
        $this->advisor_id = $slip->advisor_id;

        $this->isEdit = true;
    }

    public function cancelEdit()
    {
        $this->isEdit = false;
        $this->resetForm();
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update()
    {
        $this->validate();

        $slip = $this->slipPaymentSlipServices->find(
            $this->slip_id
        );

        abort_if(
            $slip->user_id !== auth()->id(),
            403
        );

        $this->slipPaymentSlipServices->update(
            $this->slip_id,
            [
                'title' => $this->title,
                'description' => $this->description,
                'advisor_id' => $this->advisor_id,
            ]
        );

        $this->resetForm();
        $this->isEdit = false;
    }

    /*
    |--------------------------------------------------------------------------
    | VIEW DETAIL
    |--------------------------------------------------------------------------
    */

    public function viewDetail($id)
    {
        $slip = $this->slipPaymentSlipServices->find($id);

        abort_if(
            $slip->user_id !== auth()->id() && $slip->advisor_id !== auth()->id(),
            403,
            'You do not have permission to view this form.'
        );

        $this->viewingSlip = $slip;
        $this->isViewDetail = true;
    }

    public function closeDetail()
    {
        $this->isViewDetail = false;
        $this->viewingSlip = null;
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function delete($id)
    {
        $slip = $this->slipPaymentSlipServices->find($id);

        abort_if(
            $slip->user_id !== auth()->id(),
            403
        );

        $this->slipPaymentSlipServices->delete($id);
    }

    /*
    |--------------------------------------------------------------------------
    | APPROVE
    |--------------------------------------------------------------------------
    */

    public function approve($id)
    {
        $slip = $this->slipPaymentSlipServices->find($id);

        abort_if(
            $slip->advisor_id !== auth()->id(),
            403
        );

        $this->slipPaymentSlipServices->approve($id);

        // Refresh the viewing slip
        $this->viewingSlip = $this->slipPaymentSlipServices->find($id);
    }

    /*
    |--------------------------------------------------------------------------
    | REJECT
    |--------------------------------------------------------------------------
    */

    public function reject($id)
    {
        $slip = $this->slipPaymentSlipServices->find($id);

        abort_if(
            $slip->advisor_id !== auth()->id(),
            403
        );

        $this->slipPaymentSlipServices->reject($id);

        // Refresh the viewing slip
        $this->viewingSlip = $this->slipPaymentSlipServices->find($id);
    }

    /*
    |--------------------------------------------------------------------------
    | RESET FORM
    |--------------------------------------------------------------------------
    */

    public function resetForm()
    {
        $this->reset([
            'title',
            'description',
            'advisor_id',
            'slip_id',
            'isEdit',
            'isCreate',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | RENDER
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        return view(
            'livewire.payment-slip.index',
            [
                'slips' => $this->slipPaymentSlipServices->all(
                    auth()->id()
                ),
                'users' => User::where('id', '!=', auth()->id())->get(),
            ]
        )->layout('components.layouts.app', ['title' => __('Payment Slips')]);
    }
}
