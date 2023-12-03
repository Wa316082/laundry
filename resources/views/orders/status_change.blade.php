<div class="modal-dialog">
    <form class="modal-content" id="status_change_form" action="{{ route('order.update_status',$transaction->id ) }}">
        @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Invoice Number: {{ $transaction->invoice_number }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="from-group">
            <select class="form-control" name="status" id="">
                <option value="">Select One</option>
                <option {{ old('status', $transaction->order_status) == 'Order Initialized' ? 'selected' : '' }} value="Order Initialized">Order Initialized</option>
                <option {{ old('status', $transaction->order_status) == 'Order Prepairing' ? 'selected' : '' }} value="Order Prepairing">Order Prepairing</option>
                <option {{ old('status', $transaction->order_status) == 'Ready to Deliver' ? 'selected' : '' }} value="Ready to Deliver">Ready to Deliver</option>
                <option {{ old('status', $transaction->order_status) == 'Delivered' ? 'selected' : '' }} value="Delivered">Delivered</option>
            </select>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
</div>
