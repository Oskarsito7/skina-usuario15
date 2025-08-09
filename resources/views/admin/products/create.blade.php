@extends('layouts.app')

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
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Crear Producto') }}</div>

                <div class="card-body">
                    <form action="{{ route('products.store') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Contenedor para la selección de múltiples subcategorías --}}
                        <div class="form-group row">
                            <label for="subcategory_ids" class="col-md-4 col-form-label text-md-right">{{ __('Subcategorías') }}</label>
                            <div class="col-md-6">
                                {{-- Contenedor para la lista de subcategorías seleccionadas con botones de eliminar --}}
                                <div id="selected_subcategories_list" class="space-y-2 mb-4">
                                    <!-- Las subcategorías seleccionadas se añadirán dinámicamente aquí por JavaScript -->
                                </div>

                                {{-- Botón para añadir un nuevo menú desplegable de selección de subcategorías --}}
                                <button type="button" id="add_subcategory_button" class="btn btn-primary">
                                    {{ __('Añadir Subcategoría') }}
                                </button>
                                
                                {{-- Input oculto para almacenar los subcategory_ids seleccionados para el envío del formulario --}}
                                <input type="hidden" name="subcategory_ids" id="hidden_subcategory_ids" value="">

                                @error('subcategory_ids')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Estado') }}</label>
                            <div class="col-md-6">
                                <select id="status" class="form-control @error('status') is-invalid @enderror" name="status">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
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
                                    {{ __('Crear') }}
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

{{-- Bloque PHP para definir las opciones de subcategorías, accesibles por JavaScript --}}
@php
    $subcategories = \App\Models\Subcategory::pluck('name', 'id')->toArray();
@endphp

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const subcategoryOptions = @json($subcategories);
        const selectedSubcategoriesList = document.getElementById('selected_subcategories_list');
        const addSubcategoryButton = document.getElementById('add_subcategory_button');
        const hiddenSubcategoryIdsInput = document.getElementById('hidden_subcategory_ids');

        // Array para guardar los IDs de subcategorías seleccionadas actualmente
        let selectedSubcategoryIds = [];

        /**
         * Renderiza la lista de subcategorías seleccionadas en la interfaz de usuario.
         * Cada elemento incluye el nombre de la subcategoría y un botón para eliminar.
         */
        function renderSelectedSubcategories() {
            selectedSubcategoriesList.innerHTML = ''; // Limpiar elementos de la lista existentes

            if (selectedSubcategoryIds.length === 0) {
                // Mostrar un mensaje si no hay subcategorías seleccionadas
                selectedSubcategoriesList.innerHTML = '<p class="text-gray-500">No se han seleccionado subcategorías.</p>';
            } else {
                // Crear y adjuntar elementos de lista para cada subcategoría seleccionada
                selectedSubcategoryIds.forEach((subcategoryId, index) => {
                    const subcategoryName = subcategoryOptions[subcategoryId] || 'Desconocida: ' + subcategoryId;

                    const listItem = document.createElement('div');
                    listItem.classList.add('flex', 'items-start', 'justify-between', 'bg-gray-100', 'p-2', 'rounded-md', 'shadow-sm', 'w-full');
                    listItem.innerHTML = `
                        <span class="font-medium text-gray-800 flex-grow mr-2">${subcategoryName}</span>
                        <button type="button" class="btn btn-sm btn-danger delete-subcategory-button flex-shrink-0" data-index="${index}">
                            <i class="bi bi-trash"></i>
                        </button>
                    `;
                    selectedSubcategoriesList.appendChild(listItem);
                });
            }
            updateHiddenSubcategoryIds(); // Siempre actualizar el input oculto después de renderizar
        }

        /**
         * Actualiza el valor del campo input oculto con los IDs de subcategorías seleccionadas actuales,
         * unidos por coma para el envío del formulario.
         */
        function updateHiddenSubcategoryIds() {
            hiddenSubcategoryIdsInput.value = selectedSubcategoryIds.join(',');
        }

        /**
         * Listener de eventos para el botón "Añadir Subcategoría".
         * Crea un nuevo menú desplegable para seleccionar una subcategoría.
         */
        addSubcategoryButton.addEventListener('click', function() {
            const newSubcategorySelectWrapper = document.createElement('div');
            newSubcategorySelectWrapper.classList.add('flex', 'items-center', 'space-x-2', 'mt-3', 'mb-2');

            const newSubcategorySelect = document.createElement('select');
            newSubcategorySelect.classList.add('form-control', 'subcategory-select', 'flex-grow');

            let optionDefault = document.createElement('option');
            optionDefault.value = '';
            optionDefault.textContent = 'Seleccione una subcategoría';
            newSubcategorySelect.appendChild(optionDefault);

            // Bucle corregido para evitar subcategorías ya seleccionadas
            for (const id in subcategoryOptions) {
                // Si el ID de la subcategoría no está en el array de seleccionados, la añadimos.
                if (!selectedSubcategoryIds.includes(id)) {
                    const option = document.createElement('option');
                    option.value = id;
                    option.textContent = subcategoryOptions[id];
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
                if (selectedValue && !selectedSubcategoryIds.includes(selectedValue)) {
                    selectedSubcategoryIds.push(selectedValue);
                    renderSelectedSubcategories();
                    newSubcategorySelectWrapper.remove();
                } else if (selectedSubcategoryIds.includes(selectedValue)) {
                    // Reemplazado alert() por un modal o mensaje en el futuro
                    console.log('Esta subcategoría ya ha sido seleccionada.');
                } else {
                    console.log('Por favor, seleccione una subcategoría válida.');
                }
            });
        });

        /**
         * Listener de eventos para eliminar una subcategoría. Utiliza delegación de eventos.
         */
        selectedSubcategoriesList.addEventListener('click', function(event) {
            const target = event.target.closest('.delete-subcategory-button');
            if (target) {
                const indexToDelete = target.dataset.index;
                selectedSubcategoryIds.splice(indexToDelete, 1);
                renderSelectedSubcategories();
            }
        });
    });
</script>
@endsection
