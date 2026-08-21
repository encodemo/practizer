@extends('admin::components.layouts.master')

@section('title', 'Import Data')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="mb-8">
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li>
                        <a href="{{ route('data.index') }}" class="text-gray-500 hover:text-gray-700">Data</a>
                    </li>
                    <li>
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </li>
                    <li class="text-gray-900 font-medium">Import</li>
                </ol>
            </nav>
            <h2 class="text-2xl font-bold text-gray-900">Import Data</h2>
            <p class="mt-1 text-sm text-gray-500">Upload your data file to import records</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Import Form Section --}}
            <div class="lg:col-span-2">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        {{-- Step 1: Choose File --}}
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">1. Choose File</h3>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed border-gray-300 rounded-lg hover:border-indigo-400 transition-colors cursor-pointer bg-gray-50 hover:bg-gray-100">
                                <div class="space-y-3 text-center">
                                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                                            <span>Upload a file</span>
                                            <input id="file-upload" name="file-upload" type="file" class="sr-only" accept=".xlsx,.xls,.csv">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">XLSX, XLS, CSV up to 10MB</p>
                                </div>
                            </div>
                        </div>

                        {{-- Step 2: Format Options --}}
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">2. Import Options</h3>
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <input id="skip-duplicates" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="skip-duplicates" class="ml-3 text-sm text-gray-700">
                                        Skip duplicate entries
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="update-existing" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="update-existing" class="ml-3 text-sm text-gray-700">
                                        Update existing records
                                    </label>
                                </div>
                                <div>
                                    <label for="delimiter" class="block text-sm font-medium text-gray-700 mb-2">Delimiter (for CSV)</label>
                                    <select id="delimiter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                        <option value=",">Comma (,)</option>
                                        <option value=";">Semicolon (;)</option>
                                        <option value="\t">Tab</option>
                                        <option value="|">Pipe (|)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Step 3: Preview --}}
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">3. Preview</h3>
                            <div class="bg-gray-50 rounded-lg p-4 text-center text-sm text-gray-500">
                                Upload a file to see preview
                            </div>
                        </div>
                    </div>
                    
                    {{-- Action Buttons --}}
                    <div class="px-4 py-3 bg-gray-50 sm:px-6 flex justify-end space-x-3 rounded-b-lg">
                        <a href="{{ route('data.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            Start Import
                        </button>
                    </div>
                </div>
            </div>

            {{-- Help & Instructions --}}
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-blue-50 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Import Instructions</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>Use the template file for best results</li>
                                    <li>Required fields: name, status</li>
                                    <li>Maximum file size: 10MB</li>
                                    <li>Supported formats: XLSX, XLS, CSV</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg p-4">
                    <h3 class="text-sm font-medium text-gray-900 mb-3">Quick Actions</h3>
                    <button type="button" class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 mb-2">
                        <svg class="mr-2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Download Template
                    </button>
                    <button type="button" class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        <svg class="mr-2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        View Import History
                    </button>
                </div>

                <div class="bg-yellow-50 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Important Note</h3>
                            <p class="mt-2 text-sm text-yellow-700">
                                Make sure your data is formatted correctly before importing to avoid errors.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // File input preview
    const fileInput = document.getElementById('file-upload');
    const dropZone = fileInput.closest('.border-dashed');
    
    fileInput.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            const fileName = e.target.files[0].name;
            const fileSize = (e.target.files[0].size / 1024 / 1024).toFixed(2);
            
            // Update UI to show selected file
            const fileInfo = document.createElement('div');
            fileInfo.className = 'mt-3 p-3 bg-green-50 rounded-md';
            fileInfo.innerHTML = `
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-sm text-green-700">${fileName}</span>
                    </div>
                    <span class="text-xs text-gray-500">${fileSize} MB</span>
                </div>
            `;
            
            const existingInfo = dropZone.querySelector('.bg-green-50');
            if (existingInfo) existingInfo.remove();
            dropZone.appendChild(fileInfo);
        }
    });
</script>
@endpush
