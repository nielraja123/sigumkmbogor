<!-- resources/views/components/category-dropdown.blade.php -->
<select id="category" class="form-select" style="width: 200px;">
    <option value="">Semua Kategori</option>
    @foreach ($categories as $category)
        <option value="{{ $category->category }}">{{ $category->category }}</option>
    @endforeach
</select>
