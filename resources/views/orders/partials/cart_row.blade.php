<tr class="border-bottom">
    {{-- <input type="hidden" name="row_count" value="{{ $service->row_count }}"> --}}
    <td>
        <div>
            <img class="w-50 rounded-4" src="{{ asset($service->image) }}" alt="">
            <p>{{ $service->name }}</p>
            <input type="hidden" id="service_id_{{ $service->id }}" class="service_id" name="service[{{ $service->row_count }}][service_id]" value="{{ $service->id }}">
        </div>

    </td>
    <td>
        {{ $service->category->name }}
    </td>
    <td class="">

        <input type="text" name="service[{{ $service->row_count }}][price]" class="unit_price form-control" value="{{ $service->price }}">
    </td>

    <td>
        <div class="d-flex justify-content-center gap-1">
            <button class="btn btn-xs btn-info decrease-qty">-</button>
            <input type="text" name="service[{{ $service->row_count }}][qty]" class="form-control qty" value="{{ $service->qty }}">
            <button class="btn btn-xs btn-info increase-qty">+</button>
        </div>
    </td>
    @php
        $line_total = $service->qty * $service->price;
    @endphp
    <td>
        <input type="text" readonly name="service[{{ $service->row_count }}][line_total]" class="line_total form-control" value="{{ $line_total }}">
    </td>
    <td>
        <button class="btn btn-xs btn-danger delete-row"><i class="fa-solid fa-trash"></i></button>
    </td>
</tr>
