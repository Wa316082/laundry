<div class="modal-dialog">
    <form class="modal-content" id="update_payment" action="{{ route('order.update_pay_term',$transaction->id ) }}">
        @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Invoice Number: {{ $transaction->invoice_number }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="from-group row">
            <div class="col-6">
                <label for="">Total Payable</label>
                <input class="form-control" type="number" step="any" name="total_payable" id="" disabled value="{{ ($transaction->total_payable - $transaction->amount) }}">
            </div>

            <div class="col-6">
                <label for="">Total Paying</label>
                <input class="form-control" type="number" step="any" name="total_Paying" id="">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
</div>
