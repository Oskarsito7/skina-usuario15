@extends('layouts.app')

@section('content_header')
    <h1>Editar Producto <strong>{{ $product->name }}</strong></h1>
@stop
@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('products.update', $product) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>
                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name', $product->name) }}" required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="subcategory_ids"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Subcategorías') }}</label>
                                <div class="col-md-6">
                                    <div id="selected_subcategories_list" class="space-y-2 mb-4">
                                    </div>
                                    <button type="button" id="add_subcategory_button" class="btn btn-primary">
                                        {{ __('Añadir Subcategoría') }}
                                    </button>
                                    <input type="hidden" name="subcategory_ids" id="hidden_subcategory_ids" value="">
                                    @error('subcategory_ids')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Estado') }}</label>
                                <div class="col-md-6">
                                    <select id="status" class="form-control @error('status') is-invalid @enderror"
                                        name="status">
                                        <option value="1" {{ $product->status ? 'selected' : '' }}>Activo</option>
                                        <option value="0" {{ $product->status ? '' : 'selected' }}>Inactivo</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Actualizar') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('products.index') }}" class="btn btn-info">Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Convierte las colecciones de PHP a objetos JavaScript.
            const allSubcategoryOptions = @json($allSubcategories->keyBy('id')->map->name);

            // Usa la variable que viene del controlador con los IDs de las subcategorías seleccionadas.
            const initialSelectedSubcategoryIds = @json($selectedSubcategoryIds);

            const selectedSubcategoriesList = document.getElementById('selected_subcategories_list');
            const addSubcategoryButton = document.getElementById('add_subcategory_button');
            const hiddenSubcategoryIdsInput = document.getElementById('hidden_subcategory_ids');

            // Array para guardar los IDs de subcategorías seleccionadas actualmente.
            let currentSelectedSubcategoryIds = initialSelectedSubcategoryIds;

            // ... el resto de tu código JavaScript
            // (Las funciones renderSelectedSubcategories, updateHiddenSubcategoryIds,
            //  y los listeners de eventos para los botones de añadir y eliminar se mantienen igual)

            // Llama a la función de renderizado inicial
            renderSelectedSubcategories();

            // Esta función debe ser definida para que el resto del script funcione
            function renderSelectedSubcategories() {
                selectedSubcategoriesList.innerHTML = '';
                if (currentSelectedSubcategoryIds.length === 0) {
                    selectedSubcategoriesList.innerHTML =
                        '<p class="text-gray-500">No se han seleccionado subcategorías.</p>';
                } else {
                    currentSelectedSubcategoryIds.forEach((subcategoryId) => {
                        const subcategoryName = allSubcategoryOptions[subcategoryId] || 'Desconocida: ' +
                            subcategoryId;
                        const listItem = document.createElement('div');
                        listItem.classList.add('flex', 'items-start', 'justify-between', 'bg-gray-100',
                            'p-2', 'rounded-md', 'shadow-sm', 'w-full');
                        listItem.innerHTML = `
                        <span class="font-medium text-gray-800 flex-grow mr-2">${subcategoryName}</span>
                        <button type="button" class="btn btn-sm btn-danger delete-subcategory-button flex-shrink-0" data-id="${subcategoryId}">
                            <i class="bi bi-trash"></i>
                        </button>
                    `;
                        selectedSubcategoriesList.appendChild(listItem);
                    });
                }
                updateHiddenSubcategoryIds();
            }

            function updateHiddenSubcategoryIds() {
                hiddenSubcategoryIdsInput.value = currentSelectedSubcategoryIds.join(',');
            }

            addSubcategoryButton.addEventListener('click', function() {
                const newSubcategorySelectWrapper = document.createElement('div');
                newSubcategorySelectWrapper.classList.add('flex', 'items-center', 'space-x-2', 'mt-3',
                    'mb-2');
                const newSubcategorySelect = document.createElement('select');
                newSubcategorySelect.classList.add('form-control', 'subcategory-select', 'flex-grow');
                let optionDefault = document.createElement('option');
                optionDefault.value = '';
                optionDefault.textContent = 'Seleccione una subcategoría';
                newSubcategorySelect.appendChild(optionDefault);

                for (const id in allSubcategoryOptions) {
                    if (!currentSelectedSubcategoryIds.includes(String(id))) {
                        const option = document.createElement('option');
                        option.value = id;
                        option.textContent = allSubcategoryOptions[id];
                        newSubcategorySelect.appendChild(option);
                    }
                }

                const addButton = document.createElement('button');
                addButton.type = 'button';
                addButton.classList.add('btn', 'btn-success', 'add-selected-subcategory');
                addButton.textContent = 'Añadir';

                newSubcategorySelectWrapper.appendChild(newSubcategorySelect);
                newSubcategorySelectWrapper.appendChild(addButton);
                selectedSubcategoriesList.appendChild(newSubcategorySelectWrapper);

                addButton.addEventListener('click', function() {
                    const selectedValue = newSubcategorySelect.value;
                    if (selectedValue && !currentSelectedSubcategoryIds.includes(selectedValue)) {
                        currentSelectedSubcategoryIds.push(selectedValue);
                        renderSelectedSubcategories();
                        newSubcategorySelectWrapper.remove();
                    } else if (currentSelectedSubcategoryIds.includes(selectedValue)) {
                        console.log('Esta subcategoría ya ha sido seleccionada.');
                    } else {
                        console.log('Por favor, seleccione una subcategoría válida.');
                    }
                });
            });

            selectedSubcategoriesList.addEventListener('click', function(event) {
                const target = event.target.closest('.delete-subcategory-button');
                if (target) {
                    const idToDelete = target.dataset.id;
                    const index = currentSelectedSubcategoryIds.indexOf(idToDelete);
                    if (index > -1) {
                        currentSelectedSubcategoryIds.splice(index, 1);
                        renderSelectedSubcategories();
                    }
                }
            });
        });
    </script>
@endsection
