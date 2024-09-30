<?php include("partials/head.php"); ?>

<main class="px-4">
  <div class="mt-2">
    <!-- nav header -->
    <ul class="flex space-x-4 text-white">
      <li class="after:content-['&gt;'] after:ml-3 after:text-neutral-500">
        <a href="/">Dashboard</a>
      </li>
      <li>
        <span class="cursor-default text-teal-400">Add-product</span>
      </li>

    </ul>
  </div>
  <div class="mx-auto w-3/5 px-4 py-6 sm:px-6 lg:px-8">
    <form method="POST">
      <label for="title" class="block text-sm font-medium leading-6 text-gray-50 mt-3 mb-1">Name</label>
      <input type="text" name="title" />
      <label for="company" class="block text-sm font-medium leading-6 text-gray-50 mt-3 mb-1">Company</label>
      <input type="text" name="company" />
      <label for="image" class="block text-sm font-medium leading-6 text-gray-50 mt-3 mb-1">Iamge</label>
      <input type="file" class="text-white file:mr-4 file:py-2 file:px-4
      file:rounded-md file:border-0
      file:text-sm file:font-semibold
      file:bg-red-50 file:text-blue-900
      hover:file:bg-red-100" name="image" accept="image/webp,image/jpeg,image/png" />
      <label for="description" class="block text-sm font-medium leading-6 text-gray-50 mt-3 mb-1">Description</label>
      <textarea name="description"
        rows="3"
        cols="2"
        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
      <label for="colors" class="block text-sm font-medium leading-6 text-gray-50 mt-3 mb-1">colors</label>
      <input type="text" name="colors">
      <label for="price" class="block text-sm font-medium leading-6 text-gray-50 mt-3 mb-1">Price</label>
      <input type="number" name="price">
      <div class="flex items-center justify-end">
        <button type="submit" class="mt-6 rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
          Add Product
        </button>
      </div>
    </form>
  </div>
</main>
</body>

</html>