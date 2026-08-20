@extends('admin::components.layouts.master')

@section('title', 'Export Data')

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
                    <li class="text-gray-900 font-medium">Export</li>
                </ol>
            </nav>
            <h2 class="text-2xl font-bold text-gray-900">Export Data</h2>
            <p class="mt-1 text-sm text-gray-500">Choose your export preferences</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Export Options --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Format Selection --}}
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Export Format</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            {{-- Excel Option --}}
                            <div class="relative rounded-lg border-2 border-indigo-500 bg-indigo-50 p-4 cursor-pointer">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="h-10 w-10 bg-green-100 rounded-lg flex items-center justify-center">
                                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <span class="absolute top-2 right-2 h-4 w-4 bg-indigo-500 rounded-full flex items-center justify-center">
                                        <svg class="h-3 w-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </span>
                                </div>
                                <h4 class="text-sm font-medium text-gray-900">Excel (.xlsx)</h4>
                                <p class="mt-1 text-xs text-gray-500">Best for data analysis</p>
                            </div>

                            {{-- CSV Option --}}
                            <div class="relative rounded-lg border-2 border-gray-200 p-4 cursor-pointer hover:border-gray-300">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                </div>
                                <h4 class="text-sm font-medium text-gray-900">CSV</h4>
                                <p class="mt-1 text-xs text-gray-500">Universal compatibility</p>
                            </div>

                            {{-- PDF Option --}}
                            <div class="relative rounded-lg border-2 border-gray-200 p-4 cursor-pointer hover:border-gray-300">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="h-10 w-10 bg-red-100 rounded-lg flex items-center justify-center">
                                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2zm3-6h4m-4-4h4m-4-4h4"/>
                                        </svg>
                                    </div>
                                </div>
                                <h4 class="text-sm font-medium text-gray-900">PDF</h4>
                                <p class="mt-1 text-xs text-gray-500">For printing/sharing</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Data Selection --}}
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Data Selection</h3>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input id="all-data" type="radio" name="data-selection" checked class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                <label for="all-data" class="ml-3 text-sm text-gray-700">All data</label>
                            </div>
                            <div class="flex items-center">
                                <input id="filtered-data" type="radio" name="data-selection" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                <label for="filtered-data" class="ml-3 text-sm text-gray-700">Filtered data only</label>
                            </div>
                            <div class="flex items-center">
                                <input id="selected-data" type="radio" name="data-selection" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                <label for="selected-data" class="ml-3 text-sm text-gray-700">Selected items only</label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Field Selection --}}
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Fields to Export</h3>
                        <div class="grid grid-cols-2 gap-4">
                            @foreach(['ID', 'Name', 'Description', 'Status', 'Created At', 'Updated At'] as $field)
                            <div class="flex items-center">
                                <input id="field-{{ strtolower(str_replace(' ', '-', $field)) }}" type="checkbox" checked class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="field-{{ strtolower(str_replace(' ', '-', $field)) }}" class="ml-3 text-sm text-gray-700">{{ $field }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Summary & Actions --}}
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Export Summary</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Format:</span>
                                <span class="font-medium text-gray-900">Excel (.xlsx)</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Scope:</span>
                                <span class="font-medium text-gray-900">All data (128 records)</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Fields:</span>
                                <span class="font-medium text-gray-900">6 selected</span>
                            </div>
                            <div class="border-t border-gray-200 pt-3">
                                <div class="flex justify-between text-sm font-medium">
                                    <span class="text-gray-900">Estimated file size:</span>
                                    <span class="text-gray-900">~245 KB</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 sm:px-6">
                        <button type="button" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Export Now
                        </button>
                        <a href="{{ route('data.index') }}" class="mt-2 w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Cancel
                        </a>
                    </div>
                </div>

                {{-- Export History --}}
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-sm font-medium text-gray-900 mb-3">Recent Exports</h3>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between text-sm">
                                <div>
                                    <p class="text-gray-700">data-2024-01-15.xlsx</p>
                                    <p class="text-xs text-gray-500">2 days ago</p>
                                </div>
                                <button class="text-indigo-600 hover:text-indigo-900">Download</button>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <div>
                                    <p class="text-gray-700">data-2024-01-10.csv</p>
                                    <p class="text-xs text-gray-500">1 week ago</p>
                                </div>
                                <button class="text-indigo-600 hover:text-indigo-900">Download</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
