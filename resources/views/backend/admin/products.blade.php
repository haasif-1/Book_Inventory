@extends('backend.layout.app')
@section('title', 'Products')

@section('main-content')

<div class="container-fluid py-4">

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <h4 class="fw-semibold mb-3">Products</h4>

            <div class="row g-2">
                <div class="col-md-4">
                    <input id="searchBox" class="form-control" placeholder="Search title, sku, location...">
                </div>
            </div>
        </div>
    </div>

    <!-- TABLE -->
    <div class="card shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>SKU</th>
                            <th>Stock</th>
                            <th>Sell Price</th>
                        </tr>
                    </thead>
                    <tbody id="productsBody"></tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                <button class="btn btn-outline-primary me-2" id="prevBtn">Prev</button>
                <button class="btn btn-outline-primary" id="nextBtn">Next</button>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {

    const body = document.getElementById('productsBody');
    const searchBox = document.getElementById('searchBox');
    let currentPage = 1;
    let lastPage = 1;

    loadProducts();

    async function loadProducts() {
        const query = searchBox.value || "";
        const res = await fetch(`/admin/products/data?search=${query}&page=${currentPage}`);
        const json = await res.json();

        if (!json.success) return;

        const data = json.data;
        lastPage = json.pagination.last;

        body.innerHTML = "";

        if (!data.length) {
            body.innerHTML = `<tr><td colspan="6" class="text-center text-muted">No records</td></tr>`;
            return;
        }

        data.forEach((p, i) => {
            const low = p.stock <= p.min_stock;

            body.innerHTML += `
                <tr>
                    <td>${(currentPage - 1) * 10 + (i + 1)}</td>

                    <td>
                        ${p.image 
                            ? `<img src="/storage/${p.image}" width="60" class="rounded">` 
                            : `<span class="text-muted">No Image</span>`}
                    </td>

                    <td>${p.title}</td>
                    <td>${p.sku ?? ''}</td>

                    <td>
                        ${p.stock}
                        ${low ? `<span class="badge bg-danger ms-1">Low</span>` : ""}
                    </td>

                    <td>${Number(p.sell_price).toFixed(2)}</td>
                </tr>
            `;
        });

        updateButtons();
    }

    function updateButtons() {
        document.getElementById('prevBtn').disabled = currentPage <= 1;
        document.getElementById('nextBtn').disabled = currentPage >= lastPage;
    }

    document.getElementById('prevBtn').addEventListener('click', function() {
        if (currentPage > 1) {
            currentPage--;
            loadProducts();
        }
    });

    document.getElementById('nextBtn').addEventListener('click', function() {
        if (currentPage < lastPage) {
            currentPage++;
            loadProducts();
        }
    });

    // Live search (frontend only)
    searchBox.addEventListener('input', debounce(() => {
        currentPage = 1;
        loadProducts();
    }, 300));

    function debounce(fn, delay) {
        let timer;
        return function() {
            clearTimeout(timer);
            timer = setTimeout(fn, delay);
        };
    }

});
</script>

@endsection
