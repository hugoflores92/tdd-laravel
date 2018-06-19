{{ csrf_field() }}
<div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description">Description</label>
    <input type="text" name="description" class="form-control" value="{{ old('description') ?: $transaction->description }}"/>
</div>
<div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
    <label for="amount">Amount</label>
    <input type="number" name="amount" class="form-control" value="{{ old('amount') ?: $transaction->amount }}"/>
</div>
<div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
    <label for="category_id">Category</label>
    <option value=""></option>
    <select name="category_id" class="form-control">
        @foreach($categories as $category)
            <option
                value="{{ $category->id }}"
                {{ $category->id == (old('category_id') ?: $transaction->category_id) ? 'selected="selected"' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
</div>
<button class="btn btn-success" type="submit">{{ $buttonText ?? 'Save' }}</button>