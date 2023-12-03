<div class="row row-cols-4 ">
    @forelse ($services as $service)
    <div class="col mb-4 service-cart " style="">
        <div class="card service border-3 border-info" style="cursor: pointer">
            <div class="card-body">
                <img src="{{ ($service->image != null) ? asset($service->image) : asset('image/service/default1.jpg')  }}" class="card-img-top " alt="">
            </div>
            <div class="text-center border-top bg-body-secondary" data-toggle="tooltip" data-placement="top" title="{{ ($service->name.'-'. $service->category->name)}}">
                <p>{!! Str::limit($service->category->name, 10, ' ...') !!} <br> <span>{!! Str::limit($service->name, 10, ' ...') !!}</span></p>

                <input type="hidden" value="{{ $service->id }}" class="service_id">
            </div>
        </div>
    </div>
    @empty
        <p>Empty Services</p>
    @endforelse

</div>
<div class=" d-flex justify-content-center ">
    {{ $services->links() }}
</div>
