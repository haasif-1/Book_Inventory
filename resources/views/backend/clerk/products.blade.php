@extends('backend.layout.app')
@section('title', 'Products')
@section('main-content')

    <div class="container-fluid py-4">

        <div class="card mb-3">
            <div class="card-body">
                <h5>Create / Edit Product</h5>

                <form id="productForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="product_id">

                    <div class="row g-2">

                        <div class="col-md-4">
                            <label class="form-label">Title</label>
                            <input type="text" id="title" name="title" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">SKU</label>
                            <input type="text" id="sku" name="sku" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Location</label>
                            <input type="text" id="location" name="location" class="form-control">
                        </div>

                        <div class="col-md-3 mt-2">
                            <label class="form-label">Cost Price</label>
                            <input type="number" step="0.01" id="cost_price" name="cost_price" class="form-control">
                        </div>

                        <div class="col-md-3 mt-2">
                            <label class="form-label">Sell Price</label>
                            <input type="number" step="0.01" id="sell_price" name="sell_price" class="form-control">
                        </div>

                        <div class="col-md-3 mt-2">
                            <label class="form-label">Stock</label>
                            <input type="number" id="stock" name="stock" class="form-control" value="0"
                                min="0">
                        </div>

                        <div class="col-md-3 mt-2">
                            <label class="form-label">Min Stock (Low Alert)</label>
                            <input type="number" id="min_stock" name="min_stock" class="form-control" value="1"
                                min="0">
                        </div>

                        <div class="col-md-12 mt-2">
                            <label class="form-label">Description</label>
                            <textarea id="description" name="description" class="form-control" rows="2"></textarea>
                        </div>

                        <div class="col-md-6 mt-2">
                            <label class="form-label">Image</label>
                            <input type="file" id="image" name="image" class="form-control" accept="image/*">
                            <div id="imagePreview" class="mt-2"></div>
                        </div>

                        <div class="col-md-6 mt-4 text-end">
                            <button type="button" id="btnReset" class="btn btn-outline-secondary">Reset</button>
                            <button type="submit" id="btnSave" class="btn btn-primary">Save</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>


        <!-- PRODUCT LIST -->
        <div class="card">
            <div class="card-body">

                <div class="row g-2 mb-3">
                    <div class="col-md-4">
                        <input id="globalSearch" class="form-control" placeholder="Search title, sku, location...">
                    </div>
                    <div class="col-md-2">
                        <button id="btnReload" class="btn btn-outline-primary w-100">Reload</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>SKU</th>
                                <th>Stock</th>
                                <th>Sell Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="productsBody"></tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const productBody = document.getElementById('productsBody');
            const productForm = document.getElementById('productForm');
            const btnSave = document.getElementById('btnSave');
            const btnReset = document.getElementById('btnReset');
            const globalSearch = document.getElementById('globalSearch');
            const imagePreview = document.getElementById('imagePreview');
            const csrf = document.querySelector('meta[name="csrf-token"]').content;


            loadTable();

            async function loadTable() {
                const res = await fetch(`/products/data?search=${globalSearch.value || ''}`);
                const json = await res.json();
                if (!json.success) return;

                const items = json.data;
                productBody.innerHTML = "";

                if (!items.length) {
                    productBody.innerHTML = `<tr><td colspan="7" class="text-center">No Records</td></tr>`;
                    return;
                }

                items.forEach((p, i) => {
                    const low = p.stock <= p.min_stock;
                    productBody.innerHTML += `
                <tr>
                    <td>${i + 1}</td>
                    <td>${p.image ? `<img src="${p.image}" width="60">` : ''}</td>
                    <td>${p.title}</td>
                    <td>${p.sku ?? ''}</td>
                    <td>${p.stock} ${low ? '<span class="badge bg-warning">Low</span>' : ''}</td>
                    <td>${p.sell_price}</td>
                    <td>
                        <button class="btn btn-sm btn-primary" onclick="editProduct(${p.id})">Edit</button>
                        <button class="btn btn-sm btn-danger" onclick="deleteProduct(${p.id})">Delete</button>
                    </td>
                </tr>
            `;
                });
            }


            window.editProduct = async function(id) {
                const res = await fetch(`/products/${id}`);
                const json = await res.json();

                if (!json.success) return;

                const p = json.data;

                document.getElementById('product_id').value = p.id;
                document.getElementById('title').value = p.title;
                document.getElementById('sku').value = p.sku ?? '';
                document.getElementById('location').value = p.location ?? '';
                document.getElementById('cost_price').value = p.cost_price ?? '';
                document.getElementById('sell_price').value = p.sell_price ?? '';
                document.getElementById('stock').value = p.stock ?? 0;
                document.getElementById('min_stock').value = p.min_stock ?? 1;
                document.getElementById('description').value = p.description ?? '';

                imagePreview.innerHTML = p.image ? `<img src="/storage/${p.image}" width="120">` : '';

                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            };


            window.deleteProduct = async function(id) {
                if (!confirm("Delete this product?")) return;

                const res = await fetch(`/products/${id}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": csrf
                    }
                });

                const json = await res.json();
                if (json.success) loadTable();
                alert(json.message);
            };


            // Save Product
            productForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                const id = document.getElementById('product_id').value;
                const url = id ? `/products/${id}` : "/products";

                const fd = new FormData(productForm);
                if (id) {
                    fd.append('_method', 'PUT');
                }


                btnSave.disabled = true;
                btnSave.textContent = "Saving...";

                const res = await fetch(url, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": csrf
                    },
                    body: fd
                });

                const json = await res.json();
                btnSave.disabled = false;
                btnSave.textContent = "Save";

                if (json.success) {
                    resetForm();
                    loadTable();
                    alert(json.message);
                } else {
                    alert(json.message);
                }
            });

            function resetForm() {
                productForm.reset();
                document.getElementById('product_id').value = "";
                imagePreview.innerHTML = "";
            }

            btnReset.addEventListener('click', resetForm);

            globalSearch.addEventListener('input', debounce(loadTable, 300));

            function debounce(fn, t) {
                let timer;
                return function() {
                    clearTimeout(timer);
                    timer = setTimeout(() => fn(), t);
                };
            }

        });
    </script>

@endsection
