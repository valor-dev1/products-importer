<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-6">Product List</h1>
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300">
            <thead>
                <tr>
                    <th class="border border-gray-300 px-4 py-2">ID</th>
                    <th class="border border-gray-300 px-4 py-2">Name</th>
                    <th class="border border-gray-300 px-4 py-2">Description</th>
                    <th class="border border-gray-300 px-4 py-2">Price</th>
                    <!-- Add more table headers as needed -->
                </tr>
            </thead>
            <tbody>
                <!-- Loop through your products and display them in rows -->
                @foreach($products as $product)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $product->product_id }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $product->name }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $product->description }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ number_format($product->price, 2)}}</td>
                    <!-- Add more table cells with product data -->
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
