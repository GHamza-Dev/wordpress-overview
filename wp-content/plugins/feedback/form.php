<script src="https://cdn.tailwindcss.com"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="flex justify-center">
    <form style="width: 500px; height:400px;" action="" method="POST" id="form" class="flex flex-col items-center rounded-lg p-5">
        <h1 class="text-center pb-5 text-3xl">Happy to hear from you!</h1>
        <div class="w-full my-2">
            <label for="name">Name</label>
            <input type="text" name="name" class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md py-2 pl-9 pr-3 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" placeholder="Please enter your name" required />
        </div>

        <div class="w-full my-2">
            <label for="Review" class="">Review</label>
            <textarea name="Review" class="p-3 placeholder:italic" cols="30" rows="10" placeholder="Please enter your feedback"></textarea>
            <input type="hidden" name="id" value="<?php echo get_the_ID() ?> ">
        </div>

        <div class="flex justify-between w-full items-center">
            <input type="number" max="5" min="1" value="1" name="rating" id="Rating" placeholder="rating" required />
            <button name="submit" class="bg-sky-600 hover:bg-sky-700 py-3 px-4 text-white rounded-full">Send feedback</button>
        </div>
    </form>

</div>