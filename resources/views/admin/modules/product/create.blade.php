@extends('admin.master')
@push('js')
    <script src="{{ asset('administrator/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('administrator/js/product/general.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
@endpush


@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Manage /</span>
                    Product / Create
                </h4>

            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.product.store') }}" enctype="multipart/form-data">
                    @csrf


                    <div class="row g-2">
                        <div class="col mb-2">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" class="form-control" placeholder="Enter Name"
                                name="name" value="{{ old('name') }}" />
                            @if ($errors->has('name'))
                                <span class="text-danger">* {{ $errors->get('name')[0] }}</span>
                            @endif
                        </div>

                        <div class="col mb-2">
                            <label for="price" class="form-label">Price</label>
                            <input type="text" id="price" class="form-control" placeholder="Enter price/100gram"
                                name="price" value="{{ old('price') }}" />
                            @if ($errors->has('price'))
                                <span class="text-danger">* {{ $errors->get('price')[0] }}</span>
                            @endif
                        </div>
                    </div>


                    <div class="row">
                        <div class="col mb-2">
                            <label for="sumary" class="form-label">Sumary</label>
                            <input class="form-control" id="sumary" name="sumary" value='{{ old('sumary') }}' />
                            @if ($errors->has('sumary'))
                                <span class="text-danger">* {{ $errors->get('sumary')[0] }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-2">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" rows="3" name="description">{{ old('description') }}</textarea>
                            @if ($errors->has('description'))
                                <span class="text-danger">* {{ $errors->get('description')[0] }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-2">
                            <label for="nutrition_detail" class="form-label">Nutrition</label>
                            <textarea class="form-control" id="nutrition_detail" rows="3" name="nutrition_detail">{{ old('nutrition_detail') }}</textarea>
                            @if ($errors->has('nutrition_detail'))
                                <span class="text-danger">* {{ $errors->get('nutrition_detail')[0] }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3">
                            <label for="exampleFormControlSelect2" class="form-label">Weight tag</label>
                            <select id="choices-multiple-remove-button" placeholder="Select" multiple name="weights[]">
                                @foreach ($weights as $weight)
                                    <option value="{{ $weight->id }}"
                                        {{ in_array($weight->id, old('weights', [])) ? 'selected' : '' }}>
                                        {{ $weight->mass >= 1000 ? number_format($weight->mass / 1000, 1, ',', '') . 'kg' : $weight->mass . 'gram' }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('weights'))
                                <span class="text-danger">* {{ $errors->get('weights')[0] }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col mb-2">
                            <label for="status" class="form-label ">Stataus</label>
                            <select id="status" class="form-select" name="status">
                                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Show</option>
                                <option value="2" {{ old('status') == 2 ? 'selected' : '' }}>Hidden</option>
                            </select>

                        </div>
                        <div class="col mb-2">
                            <label for="category_id" class="form-label">Category</label>
                            <select id="category_id" class="form-select" name="category_id">
                                @php
                                    RootCategory($categories, old('category_id', 0));
                                @endphp
                            </select>
                        </div>
                        <div class="col mb-2">
                            <label for="feature" class="form-label">Feature</label>
                            <select id="feature" class="form-select" name="feature">
                                <option value="1" {{ old('feature') == 1 ? 'selected' : '' }}>Featured</option>
                                <option value="2" {{ old('feature') == 2 ? 'selected' : '' }}>Unfeatured</option>
                            </select>
                        </div>

                    </div>

                    <div class="row">
                        <label for="customFile1" class="form-label">Image</label>

                        <div class="mb-4 d-flex">
                            <img id="selectedImage" src="https://mdbootstrap.com/img/Photos/Others/placeholder.jpg"
                                alt="example placeholder" style="width: 250px; height: 250px" />
                        </div>
                        <div class="d-flex">
                            <div class="btn btn-primary btn-rounded w-px-250">
                                <label class="form-label text-white m-1 " for="customFile1">Choose file</label>
                                <input type="file" class="form-control d-none " id="customFile1"
                                    onchange="displaySelectedImage(event, 'selectedImage')" name="image" />
                            </div>
                        </div>
                        @if ($errors->has('image'))
                            <span class="text-danger">* {{ $errors->get('image')[0] }}</span>
                        @endif
                    </div>


                    <div class="row ">
                        <div class="col d-flex  justify-content-end">
                            <button type="submit" id="submit" class="btn btn-primary " style="margin-right: 4px">Create</button>
                            <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>

                    </div>



                </form>

            </div>

        </div>


    </div>
    <!-- /.card -->
@endsection
