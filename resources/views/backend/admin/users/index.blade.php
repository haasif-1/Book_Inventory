@extends('backend.layout.app')
@section('title','Users')

@section('main-content')

<div class="container-fluid py-4">

    {{-- ================= MY PROFILE CARD ================= --}}
    <div class="card shadow-sm border-left-primary mb-4">
        <div class="card-header bg-dark text-white d-flex justify-content-between">
            <h4 class="mb-0">My Profile</h4>

            <a href="{{ route('users.edit', auth()->id()) }}" class="btn btn-warning btn-sm">
                Edit My Profile
            </a>
        </div>

        <div class="card-body">
            <table class="table table-bordered mb-0">
                <tr>
                    <th width="150">Name</th>
                    <td>{{ auth()->user()->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ auth()->user()->email }}</td>
                </tr>
                <tr>
                    <th>Role</th>
                    <td>{{ auth()->user()->roles->pluck('name')->join(', ') }}</td>
                </tr>
            </table>
        </div>
    </div>


    {{-- ================= USER MANAGEMENT ================= --}}
    <div class="d-flex justify-content-between mb-3">
        <h3>User Management</h3>
        <a href="{{ route('users.create') }}" class="btn btn-primary">Create User</a>
    </div>

    {{-- SEARCH & FILTER --}}
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-4">
                    <label class="form-label">Search Users</label>
                    <input type="text" id="searchBox" class="form-control" placeholder="Type to search...">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Search By</label>
                    <select id="searchField" class="form-control">
                        <option value="name">Name</option>
                        <option value="email">Email</option>
                        <option value="role">Role</option>
                    </select>
                </div>

                {{-- <div class="col-md-2 d-flex align-items-end">
                    <button id="btnReset" class="btn btn-secondary w-100">Reset</button>
                </div> --}}

            </div>
        </div>
    </div>


    <div class="card shadow-sm">
        <div class="card-body table-responsive">

            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th width="50">#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>

                <tbody id="userTableBody">

                    @php $row = 1; @endphp

                    @foreach ($users as $u)
                        @if(auth()->id() == $u->id)
                            @continue
                        @endif

                        <tr>
                            <td>{{ $row++ }}</td>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->roles->pluck('name')->join(', ') }}</td>

                            <td>
                                <a href="{{ route('users.edit', $u->id) }}" 
                                   class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('users.destroy', $u->id) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this user?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>

                    @endforeach

                </tbody>
            </table>

        </div>
    </div>

</div>



{{-- AJAX FILTER SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function() {

    const searchBox = document.getElementById('searchBox');
    const searchField = document.getElementById('searchField');
    const tableBody = document.getElementById('userTableBody');
    const resetBtn = document.getElementById('btnReset');

    function filterTable() {
        const text = searchBox.value.toLowerCase();
        const field = searchField.value;

        const rows = tableBody.querySelectorAll('tr');

        rows.forEach(row => {
            const name  = row.children[1].innerText.toLowerCase();
            const email = row.children[2].innerText.toLowerCase();
            const role  = row.children[3].innerText.toLowerCase();

            let checkValue = "";

            if (field === "name")  checkValue = name;
            if (field === "email") checkValue = email;
            if (field === "role")  checkValue = role;

            if (checkValue.includes(text)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });

    }

    searchBox.addEventListener('input', filterTable);
    searchField.addEventListener('change', filterTable);

    resetBtn.addEventListener('click', () => {
        searchBox.value = "";
        filterTable();
    });

});
</script>

@endsection
