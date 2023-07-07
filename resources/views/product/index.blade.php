@extends('main')
@extends('sidebar')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Product</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Product</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List Product</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                            <i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                            title="Remove">
                            <i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div style="padding-bottom: 5%;">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAddProduct">
                            <i class="fas fa-plus"></i> Product
                        </button>
                    </div>
                    <table id="table-product" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Created At</th>
                                <th>Name</th>
                                <th style="width: 30%;">Image</th>
                                <th>Stock</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product as $row)
                                <tr>
                                    <td>{{ date('d-m-Y H:i:s', strtotime($row->created_at)) }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td style="text-align: center;"><img
                                            src="{{ asset('/assets/uploads/images/product/') . '/' . $row->image }}"
                                            style="width: 20%;" /> </td>
                                    <td>{{ $row->stock }}</td>
                                    <td>{{ $row->price }}</td>
                                    <td style="text-align: center;">
                                        <a class="btn" data-toggle='modal' id='buttonEditProduct'
                                            data-productId="{{ $row->id }}" data-productName="{{ $row->name }}"><i
                                                class='fas fa-pencil-alt'></i>
                                        </a>
                                        <a class="btn" data-toggle='modal' id='buttonDeleteProduct'
                                            data-target='#deleteProduct' data-productId="{{ $row->id }}"><i
                                                class='fas fa-trash'></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    &nbsp;
                </div>
                <!-- /.card-footer-->
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    </div>

    <div class="modal fade" id="modalAddProduct">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="fas fa-plus"></span> &nbsp;&nbsp;&nbsp; <h5 class="modal-title"> Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                </div>
                <form type="POST" enctype="multipart/form-data" id="formAddProduct">
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input autofocus type="text" class="form-control" placeholder="Name Product"
                                    name="name" id="name">
                                <span class="text-danger form-validate" id="nameError"></span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Image</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="imageProduct" id="imageProduct">
                                <span class="text-danger form-validate" id="imageProductError"></span>
                                <img id="previewImageProduct" src="#" alt="your image" class="mt-3"
                                    style="display:none; width:80%;" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Stock</label>
                            <div class="col-sm-9">
                                <input autofocus type="number" class="form-control" placeholder="Product Stock"
                                    name="stock" id="stock">
                                <span class="text-danger form-validate" id="stockError"></span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Price</label>
                            <div class="col-sm-9">
                                <input autofocus type="number" class="form-control" placeholder="Product Price"
                                    name="price" id="price">
                                <span class="text-danger form-validate" id="priceError"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-dismiss="modal">Cancel</button>
                        <div id="divBtnSubmitAddProduct">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        <div id="divBtnSubmitAddProductLoading" style="display: none;">
                            <button class="btn btn-primary" disabled><i class="fa fa-spinner fa-spin"></i> Process
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- UPDATE --}}
    <div class="modal fade" id="modal_edit_product">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="fas fa-pencil-alt"></span> &nbsp;&nbsp;&nbsp; <h5 class="modal-title"> Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                </div>
                <form type="POST" enctype="multipart/form-data" id="formEditProduct">
                    <input type="hidden" class="form-control" name="productId_edit" id="id_edit">
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input autofocus type="text" class="form-control" placeholder="Name Product"
                                    name="name" id="name_edit">
                                <span class="text-danger form-validate" id="nameEditError"></span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Image</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="imageProductEdit"
                                    id="imageProductEdit">
                                <span class="text-danger form-validate" id="imageProductError"></span>
                                <img id="previewImageProductEdit" src="#" alt="your image" class="mt-3"
                                    style="display:none; width:80%;" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Stock</label>
                            <div class="col-sm-9">
                                <input autofocus type="number" class="form-control" placeholder="Product Stock"
                                    name="stock" id="stock_edit">
                                <span class="text-danger form-validate" id="stockEditError"></span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Price</label>
                            <div class="col-sm-9">
                                <input autofocus type="number" class="form-control" placeholder="Product Price"
                                    name="price" id="price_edit">
                                <span class="text-danger form-validate" id="priceEditError"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-dismiss="modal">Cancel</button>
                        <div id="divBtnSubmitEditProduct">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        <div id="divBtnSubmitEditProductLoading" style="display: none;">
                            <button class="btn btn-primary" disabled><i class="fa fa-spinner fa-spin"></i> Process
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- DELETE --}}
    <div class="modal fade" id="modal_delete_product">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="fas fa-trash"></span> &nbsp;&nbsp;&nbsp; <h5 class="modal-title"> Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                </div>
                <form type="POST" enctype="multipart/form-data" id="formDeleteProduct">
                    <input type="hidden" class="form-control" name="productId_delete" id="id_delete">
                    <div class="modal-body">
                        <p>Are you sure want to <b>DELETE</b> data?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-dismiss="modal">Cancel</button>
                        <div id="divBtnSubmitDeleteProduct">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        <div id="divBtnSubmitDeleteProductLoading" style="display: none;">
                            <button class="btn btn-primary" disabled><i class="fa fa-spinner fa-spin"></i> Process
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        imageProduct.onchange = evt => {
            previewImageProduct = document.getElementById('previewImageProduct');
            previewImageProduct.style.display = 'block';
            const [file] = imageProduct.files
            if (file) {
                previewImageProduct.src = URL.createObjectURL(file)
            }
        }
        // edit
        imageProductEdit.onchange = evt => {
            previewImageProductEdit = document.getElementById('previewImageProductEdit');
            previewImageProductEdit.style.display = 'block';
            const [file] = imageProductEdit.files
            if (file) {
                previewImageProductEdit.src = URL.createObjectURL(file)
            }
        }
    </script>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#formAddProduct').on('submit', function(e) {
                    e.preventDefault();
                    var formData = new FormData($(this)[0]);
                    document.getElementById("divBtnSubmitAddProduct").style.display = "none";
                    document.getElementById("divBtnSubmitAddProductLoading").style.display = "block";
                    var name = $("#name").val();
                    var image = $("#imageProduct").val();
                    var stock = $("#stock").val();
                    var price = $("#price").val();

                    let validation = 0;
                    //validation
                    if (name.length == 0 || name == "") {
                        $('#nameError').text("Name is required");
                        $('#name').addClass('form-error');
                        validation++;
                    } else {
                        $('#nameError').text("");
                        $('#name').removeClass('form-error');
                    }
                    if (image.length == 0 || image == "") {
                        $('#imageProductError').text("Image is required");
                        $('#imageProduct').addClass('form-error');
                        validation++;
                    } else {
                        $('#imageProductError').text("");
                        $('#imageProduct').removeClass('form-error');
                    }
                    if (stock.length == 0 || stock == "") {
                        $('#stockError').text("Stock is required");
                        $('#stock').addClass('form-error');
                        validation++;
                    } else {
                        $('#stockError').text("");
                        $('#stock').removeClass('form-error');
                    }
                    if (price.length == 0 || price == "") {
                        $('#priceError').text("Price is required");
                        $('#price').addClass('form-error');
                        validation++;
                    } else {
                        $('#priceError').text("");
                        $('#price').removeClass('form-error');
                    }
                    if (validation > 0) {
                        document.getElementById("divBtnSubmitAddProduct").style.display = "block";
                        document.getElementById("divBtnSubmitAddProductLoading").style.display = "none";
                        return false;
                    }
                    //end validation

                    e.preventDefault();
                    $.ajax({
                        url: "{{ route('product.add') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        dataType: "JSON",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.status == 200) {
                                Swal.fire({
                                    type: 'success',
                                    title: 'Insert Success',
                                    text: 'Product success insert. .',
                                }).then(function() {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    type: 'error',
                                    title: 'Insert Failed!',
                                    text: response.message
                                }).then(function() {
                                    document.getElementById("divBtnSubmitAddProduct").style
                                        .display = "block";
                                    document.getElementById("divBtnSubmitAddProductLoading")
                                        .style.display = "none";
                                });
                            }
                        },
                        error: function(response) {
                            // console.log(response.message);
                            Swal.fire({
                                type: 'error',
                                title: 'Opps!',
                                text: 'server error!'
                            }).then(function() {
                                document.getElementById("divBtnSubmitAddProduct").style
                                    .display = "block";
                                document.getElementById("divBtnSubmitAddProductLoading")
                                    .style
                                    .display = "none";
                            });
                        }
                    });
                });
            });
        </script>

        {{-- EDIT --}}
        <script>
            $(document).on('click', '#buttonEditProduct', function(event) {
                event.preventDefault();
                var productId = $(this).attr('data-productId');
                $.ajax({
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('product.data') }}",
                    data: {
                        id: productId
                    },
                    beforeSend: function() {
                        $('#preloader').show();
                    },
                    success: function(result) {
                        $('#id_edit').val(result.id);
                        $('#name_edit').val(result.name);
                        $('#price_edit').val(result.price);
                        $('#stock_edit').val(result.stock);
                        $('#image_edit').val(result.image);
                        // Display the image preview
                        var previewImageProductEdit = $('#previewImageProductEdit');
                        previewImageProductEdit.attr('src',
                            "{{ asset('/assets/uploads/images/product/') }}/" + result.image);
                        previewImageProductEdit.show();

                        $('#modal_edit_product').modal("show");
                    },
                    complete: function() {
                        $('#preloader').hide();
                    },
                    error: function(jqXHR, testStatus, error) {
                        alert("Page " + href + " cannot open. Error:" + error);
                        $('#preloader').hide();
                    },
                    timeout: 8000
                })
            });

            // POST EDIT
            $(document).ready(function() {
                $('#formEditProduct').on('submit', function(e) {
                    e.preventDefault();
                    var formData = new FormData($(this)[0]);
                    document.getElementById("divBtnSubmitEditProduct").style.display = "none";
                    document.getElementById("divBtnSubmitEditProductLoading").style.display = "block";
                    var productId_edit = $("#id_edit").val();
                    var name = $("#name_edit").val();
                    // var image = $("#imageProductEdit").val();
                    var stock = $("#stock_edit").val();
                    var price = $("#price_edit").val();

                    let validation = 0;
                    //validation
                    if (name.length == 0 || name == "") {
                        $('#nameEditError').text("Name is required");
                        $('#name_edit').addClass('form-error');
                        validation++;
                    } else {
                        $('#nameEditError').text("");
                        $('#name_edit').removeClass('form-error');
                    }

                    if (stock.length == 0 || stock == "") {
                        $('#stockEditError').text("Stock is required");
                        $('#stock_edit').addClass('form-error');
                        validation++;
                    } else {
                        $('#stockEditError').text("");
                        $('#stock_edit').removeClass('form-error');
                    }

                    if (price.length == 0 || price == "") {
                        $('#priceEditError').text("Price is required");
                        $('#price_edit').addClass('form-error');
                        validation++;
                    } else {
                        $('#priceEditError').text("");
                        $('#price_edit').removeClass('form-error');
                    }
                    console.log(validation);
                    if (validation > 0) {
                        document.getElementById("divBtnSubmitEditProduct").style.display = "block";
                        document.getElementById("divBtnSubmitEditProductLoading").style.display = "none";
                        return false;
                    }
                    //end validation
                    $.ajax({
                        url: "{{ route('product.edit') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        dataType: "JSON",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.status == 200) {
                                Swal.fire({
                                    type: 'success',
                                    title: 'Success Update Product',
                                    text: 'success Update product. .',
                                }).then(function() {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    type: 'error',
                                    title: 'Insert Failed!',
                                    text: response.message
                                }).then(function() {
                                    document.getElementById("divBtnSubmitEditProduct").style
                                        .display = "block";
                                    document.getElementById(
                                            "divBtnSubmitEditProductLoading")
                                        .style.display = "none";
                                });
                            }
                        },
                        error: function(response) {
                            // console.log(response.message);
                            Swal.fire({
                                type: 'error',
                                title: 'Opps!',
                                text: 'server error!'
                            }).then(function() {
                                document.getElementById("divBtnSubmitEditProduct").style
                                    .display = "none";
                                document.getElementById("divBtnSubmitEditProductLoading")
                                    .style.display = "block";
                            });
                        }
                    });
                });
            });
        </script>

        {{-- DELETE --}}
        <script>
            $(document).on('click', '#buttonDeleteProduct', function(event) {
                event.preventDefault();
                var productId = $(this).attr('data-productId');
                $.ajax({
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('product.data') }}",
                    data: {
                        id: productId
                    },
                    beforeSend: function() {
                        $('#preloader').show();
                    },
                    success: function(result) {
                        $('#id_delete').val(result.id);

                        $('#modal_delete_product').modal("show");
                    },
                    complete: function() {
                        $('#preloader').hide();
                    },
                    error: function(jqXHR, testStatus, error) {
                        alert("Page " + href + " cannot open. Error:" + error);
                        $('#preloader').hide();
                    },
                    timeout: 8000
                })
            });

            // POST DELETE
            $(document).ready(function() {
                $('#formDeleteProduct').on('submit', function(e) {
                    e.preventDefault();
                    var formData = new FormData($(this)[0]);
                    document.getElementById("divBtnSubmitDeleteProduct").style.display = "none";
                    document.getElementById("divBtnSubmitDeleteProductLoading").style.display = "block";
                    var productId_edit = $("#id_edit").val();

                    let validation = 0;
                    //validation
                    $.ajax({
                        url: "{{ route('product.delete') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        dataType: "JSON",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.status == 200) {
                                Swal.fire({
                                    type: 'success',
                                    title: 'Success Delete Product',
                                    text: 'success Delete product. .',
                                }).then(function() {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    type: 'error',
                                    title: 'Delete Failed!',
                                    text: response.message
                                }).then(function() {
                                    document.getElementById("divBtnSubmitDeleteProduct")
                                        .style
                                        .display = "block";
                                    document.getElementById(
                                            "divBtnSubmitDeleteProductLoading")
                                        .style.display = "none";
                                });
                            }
                        },
                        error: function(response) {
                            // console.log(response.message);
                            Swal.fire({
                                type: 'error',
                                title: 'Opps!',
                                text: 'server error!'
                            }).then(function() {
                                document.getElementById("divBtnSubmitDeleteProduct").style
                                    .display = "none";
                                document.getElementById("divBtnSubmitDeleteProductLoading")
                                    .style.display = "block";
                            });
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection

@extends('footer')
