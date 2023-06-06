@extends('admin.layout.layout')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create product</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">List Products</a></li>
                        <li class="breadcrumb-item active">Create product</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <!-- /.card-header -->

                            {{-- tab --}}
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="general_tab" data-toggle="tab"
                                        data-target="#general" type="button" role="tab" aria-controls="#general"
                                        aria-selected="true">Basic information</button>
                                    <button class="nav-link" id="advanced_tab" data-toggle="tab" data-target="#advanced"
                                        type="button" role="tab" aria-controls="advanced"
                                        aria-selected="false">Detail information</button>
                                   
                                </div>
                            </nav>

                            {{-- cardbody --}}
                            <div class="card-body tab-content" id="nav-tabContent">
                                {{-- tab general  --}}
                                <div class="tab-pane fade show active" id="general" role="tabpanel"
                                    aria-labelledby="general_tab" tabindex="0">
                                    <div class="form-group">
                                        <label for="name">Product Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="product Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">stock</label>
                                        <input type="number" class="form-control" id="stock" name="stock"
                                            placeholder="stock">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">price</label>
                                        <input type="number" class="form-control" id="price" name="price"
                                            placeholder="price">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">sale price</label>
                                        <input type="number" class="form-control" id="saleprice" name="sale_price"
                                            placeholder="saleprice">
                                    </div>
                                    <div class="form-group">
                                        <label>Select category</label>
                                        <select class="form-control select2" style="width: 100%;" name="category_id">
                                            <option value='0'>Select category</option>
                                            @foreach ($childCategories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Select tags</label>
                                        <select class="form-control select2-tags" style="width: 100%;" name="tags[]" multiple>
                                            @foreach ($tags as $tag)
                                                <option value="{{ $tag->id }}" >
                                                    {{ $tag->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" name="is_hot" class="form-check-input" id="is_hot">
                                        <label class="form-check-label" for="is_hot">Is hot product</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active">
                                        <label class="form-check-label" for="is_active">Is Active product</label>
                                    </div>
                                    <div class="form-group">
                                        <label for="thumbnail">Thumbnail</label>
                                        <input type="file" class="form-control-file" id="thumbnail" name="thumbnail">
                                    </div>
                                    <div class="preview_thumb row"></div>

                                    <div class="form-group">
                                        <label for="images">Images</label>
                                        <input type="file" class="form-control-file images" id="images"
                                            name="images[]" multiple>
                                    </div>
                                    <div class="preview row"></div>

                                </div>

                                {{-- tab advanced  --}}

                                <div class="tab-pane fade" id="advanced" role="tabpanel"
                                    aria-labelledby="advanced_tab">

                                    <div class="form-group">
                                        <label for="description">Description</label>

                                        <textarea class="form-control tinymce" id="description" rows="1" name='description'></textarea>
                                        {{-- <textarea class="form-control tinymce" id="description" rows="1" name='description'></textarea> --}}
                                    </div>
                                    <div class="form-group">
                                        <label for="content">content</label>
                                        <textarea class="form-control tinymce" id="content" rows="3" name='content'></textarea>
                                    </div>
                                </div>
                            </div>
                    </div>


                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <button type="submit" class="btn btn-primary">Save product</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <a class="btn btn-warning" href="{{ route('categories.index') }}">Back</a>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection

@push('custom-js')
    <script>
        $(document).ready(function() {
            $('#thumbnail').change(function() {
                $('.preview_thumb').empty(); // clear previous preview images
                for (const file of this.files) {
                    let reader = new FileReader();

                    reader.onload = function(e) {
                        $('.preview_thumb').append(`<div class="col-md-3 h-100"><img class="w-100 h-100" src="${e.target.result}" alt=""></div>
    `);
                    }
                    reader.readAsDataURL(file);
                }
            })
            $('#images').change(function() {
                $('.preview').empty(); // clear previous preview images
                for (const file of this.files) {
                    let reader = new FileReader();

                    reader.onload = function(e) {
                        $('.preview').append(`<div class="col-md-3 h-100"><img class="w-100 h-100" src="${e.target.result}" alt=""></div>
    `);
                    }
                    reader.readAsDataURL(file);
                }
            })
        })
        $('.select2').select2();
        $('.select2-tags').select2({
            multiple: true,
            tags: true,
            delay: 500,
            ajax: {
                url: '{{route('tags.searchTag')}}',
                dataType: 'json',
                perPage: 9,
                // data gửi lên server 
                data: function(params) {
                    var query = {
                        search: params.term,
                        page: params.page || 1
                    }

                    // Query parameters will be ?search=[term]&page=[page]
                    return query;
                },
                // nội dung xử lí, biến data trong function bên dưới này là data sever trả về
                processResults: function(data, params) {
                    params.page = params.page || 1;

                    let results = [];

                    console.log(data.data);

                    for (const tag of data.data) {
                        results.push({
                            id: tag.id,
                            text: tag.name,
                        })
                        console.log(tag);
                    }

                    return {
                        results: results,
                        pagination: {
                            more: (params.page * 9) < data.total
                        }
                    };
                }
                
            }

        });
    </script>
@endpush
