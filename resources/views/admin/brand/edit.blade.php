<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           Edit Brand
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            Edit Brand
                        </div>
                        <div class="card-body">
                            <form action="{{url('brand/update/'.$brand->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="old_image" value="{{$brand->brand_image}}">
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="form-label">Update Brand Name</label>
                                    <input class="form-control" value="{{$brand->brand_name}}" name="brand_name" type="text">
                                    @error('brand_name')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="form-label">Update Brand Image</label>
                                    <input class="form-group" value="{{$brand->brand_image}}" name="brand_image" type="file">
                                    @error('brand_image')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <img src="{{asset($brand->brand_image)}}" alt="brand_image" style="width:400px; height:200px;"/>
                                </div>
                                <button class="form-group btn btn-info" type="submit">Update Brand</button>
                            </form>
                        </div>
                    </div>
                </div> 
            </div>
        </div> 
    </div>
</x-app-layout>
