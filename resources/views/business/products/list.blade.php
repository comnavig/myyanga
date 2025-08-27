@extends('layouts.business')

@section('title', 'All Products') {{-- Sets the page title --}}
@section('page.title', 'All Products') {{-- Sets the breadcrumb or heading title --}}
@section('content')

{{-- ✅ Success alert --}}
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

{{-- ✅ Error alert --}}
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="container mt-2">
    <div class="my-4 d-flex justify-content-between align-items-center">
        <h3 class="main-color">All Products</h3>

        {{-- ✅ Bulk delete form --}}
        <form id="bulk-delete-form" method="POST" action="{{ route('listings.bulk.delete.products') }}" onsubmit="return confirm('Are you sure you want to delete the selected products?');">
            @csrf
            <input type="hidden" name="product_ids" id="product_ids_input"> {{-- Selected product IDs --}}
            <input type="hidden" name="search" value="{{ request('search') }}"> {{-- Keep current search query --}}
            <input type="hidden" name="page" value="{{ request('page', 1) }}"> {{-- Keep current page --}}
            <button type="submit" class="btn btn-danger btn-sm" disabled id="bulk-delete-btn">Delete Selected</button>
        </form>
    </div>

    {{-- ✅ Search form --}}
    <form method="GET" action="{{ url()->current() }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="form-control form-control-sm">
            <button class="btn btn-secondary btn-sm" type="submit">Search</button>
        </div>
    </form>

    {{-- ✅ Show back to all products if search query is present --}}
    @if (request('search'))
        <a href="{{ route('products') }}" class="btn btn-sm btn-outline-secondary mb-3">← Back to All Products</a>
    @endif

    <div id="results" class="col-12 float-left py-3">
        {{-- ✅ Show results info --}}
        <h4 class="main-color">
            Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() ?? 0 }} entries
        </h4>

        {{-- ✅ If no results and search is active --}}
        @if($products->isEmpty() && request('search'))
            <div class="alert alert-warning">
                No item found for search keyword: <strong>{{ request('search') }}</strong>
            </div>
        @endif
    </div>

    {{-- ✅ Only render the table if there are products --}}
    @if($products->count())
    <div class="col-12">
        <table class="table table-sm dt">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"></th> {{-- Select all checkbox --}}
                    <th>Picture</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Created on</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td><input type="checkbox" class="product-checkbox" value="{{ $product->id }}"></td>
                    <!--<td><img src="{{ $product->picture[0]->url ?? '' }}" alt="" width="60"></td>-->
                    <td>
                        <div style="width: 100px; height: 100px; overflow: hidden;">
                            @if(isset($product->picture[0]['url']))
                                <img 
                                    src="{{ str_replace('https://myyanga.fra1.digitaloceanspaces.com/', 'https://myyanga.com/storage/', $product->picture[0]['url']) }}" 
                                    width="100%" 
                                    alt="Product Image"
                                />
                            @else
                                <p>No image available</p>
                            @endif
                        </div>
                    </td>

                    <td>
                        {{ $product->name }}<br/>
                        <small>
                            <a target="_blank" href="{{ route('brand.product', ['slug' => $product->listing->slug, 'product_slug' => $product->slug ]) }}">
                                view product page
                            </a>
                        </small>
                    </td>
                    <td>{{ $product->category->name ?? '' }}</td>
                    <td>{{ $product->created_at->format('Y-m-d') }}</td>
                    <td><span class="font-weight-bold {{ strtolower($product->status) }}">{{ $product->status }}</span></td>
                    <td>
                        {{-- ✅ Show Edit and Delete buttons if not suspended --}}
                        @if($product->status !== 'SUSPENDED')
                            <div class="btn-group">
                                <a class="btn btn-sm main-btn-bg mr-2" href="{{ route('listings.edit.product', ['id' => $product->id]) }}">EDIT</a>
                                @if($product->sold->count() == 0)
                                    <form method="POST" action="{{ route('listings.delete.product') }}" onsubmit="return confirm('Confirm delete?')">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button class="btn btn-sm warm-red-bg">DELETE</button>
                                    </form>
                                @endif
                            </div>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{-- ✅ Pagination --}}
        <div class="pagination-wrapper">
            {{ $products->withQueryString()->links() }}
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // ✅ When the "select all" checkbox is toggled
    document.getElementById('select-all').addEventListener('change', function() {
        const checked = this.checked;
        document.querySelectorAll('.product-checkbox').forEach(cb => { cb.checked = checked; });
        toggleBulkDeleteButton();
    });

    // ✅ When any checkbox is toggled individually
    document.querySelectorAll('.product-checkbox').forEach(cb => {
        cb.addEventListener('change', toggleBulkDeleteButton);
    });

    // ✅ Enable or disable the bulk delete button based on selected checkboxes
    function toggleBulkDeleteButton() {
        const selectedIds = Array.from(document.querySelectorAll('.product-checkbox:checked')).map(cb => cb.value);
        document.getElementById('bulk-delete-btn').disabled = selectedIds.length === 0;
        document.getElementById('product_ids_input').value = selectedIds.join(',');
    }
</script>
@endpush
