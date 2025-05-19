@props(['action', 'method' => 'POST'])

<form action="{{ $action }}" method="{{ in_array(strtoupper($method), ['GET', 'POST']) ? $method : 'POST' }}" {{ $attributes }}>
    @csrf
    @if(!in_array(strtoupper($method), ['GET', 'POST']))
        @method($method)
    @endif

    <div class="space-y-6">
        {{ $slot }}
    </div>
</form>

@props(['for', 'label' => null])

<div class="form-group">
    @if($label)
        <label for="{{ $for }}" class="form-label">
            {{ $label }}
        </label>
    @endif

    {{ $slot }}

    @error($for)
        <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
    @enderror
</div>

@props(['type' => 'text', 'name', 'id' => null, 'value' => null])

<input 
    type="{{ $type }}"
    name="{{ $name }}"
    id="{{ $id ?? $name }}"
    value="{{ old($name, $value) }}"
    {{ $attributes->merge(['class' => 'form-input']) }}
/>

@props(['name', 'id' => null, 'value' => null])

<textarea
    name="{{ $name }}"
    id="{{ $id ?? $name }}"
    {{ $attributes->merge(['class' => 'form-input', 'rows' => 3]) }}
>{{ old($name, $value) }}</textarea>

@props(['name', 'id' => null, 'options' => [], 'value' => null])

<select
    name="{{ $name }}"
    id="{{ $id ?? $name }}"
    {{ $attributes->merge(['class' => 'form-input']) }}
>
    @foreach($options as $optionValue => $label)
        <option value="{{ $optionValue }}" {{ old($name, $value) == $optionValue ? 'selected' : '' }}>
            {{ $label }}
        </option>
    @endforeach
</select>

@props(['type' => 'submit'])

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => 'btn btn-primary']) }}
>
    {{ $slot }}
</button> 