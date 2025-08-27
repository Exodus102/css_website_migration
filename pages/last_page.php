<div class="min-h-screen flex flex-col items-center justify-start relative bg-cover bg-center" 
     style="background-image: url('resources/svg/landing-page.svg');">

  <!-- Logo -->
  <div class="flex items-center justify-center gap- mb-3 mt-6">
    <img src="resources/svg/logo.svg" alt="URSatisfaction Logo" class="h-20">
    <div class="text-left">
      <h2 class="text-2xl font-bold leading-tight">
        <span class="text-[#95B3D3]">URS</span><span class="text-[#F1F7F9]">atisfaction</span>
      </h2>
      <p class="text-sm text-[#F1F7F9] leading-snug">We comply so URSatisfied</p>
    </div>
  </div>

  <!-- White Border -->
  <div class="bg-white shadow-2xl rounded-lg w-full max-w-[90%] p-14 mx-6 min-h-[610px] mt-14">
    <!-- Inner wrapper with extra padding -->
    <div class="w-full max-w-2xl mx-auto space-y-10 px-10">

      <!-- Title -->
      <div class="text-left">
        <h1 class="text-3xl font-bold text-[#1E1E1E] mb-3 leading-snug">Your thoughts matter!</h1>
        <p class="text-lg text-[#1E1E1E] leading-relaxed">
          We’d love to hear your comments and suggestions to serve you better.
        </p>
      </div>
<!-- Form -->
<form action="process.php" method="POST" class="space-y-8">

  <!-- Comments -->
  <div>
    <label class="block text-[#1E1E1E] text-lg mb-3 leading-snug">Comments and suggestions:</label>
    <textarea 
      name="comments" 
      rows="4" 
      class="w-full border border-[#1E1E1E] rounded-md px-4 py-3 text-lg text-[#1E1E1E] leading-relaxed focus:outline-none focus:ring-2 focus:ring-[#064089]"
    ></textarea>
  </div>

  <!-- Agreement -->
<div class="flex items-start gap-2">
  <input type="checkbox" id="agree" name="agree" required
         class="mt-1 w-5 h-5 text-[#064089] border-gray-300 rounded focus:ring-[#064089]">
  <label for="agree" class="text-sm text-[#1E1E1E] leading-relaxed">
    By ticking, you are confirming that you have read, understood, and agree to the URSatisfaction: Customer Satisfaction Survey System 
    <a href="#" class="text-[#064089] !underline underline-offset-2 decoration-[#064089]">
      privacy policy
    </a> and 
    <a href="#" class="text-[#064089] !underline underline-offset-2 decoration-[#064089]">
      terms of services
    </a>.
  </label>
</div>

  <!-- Buttons -->
  <div class="flex justify-between items-center">
   <!-- Back Arrow -->
    <a href="pages/first_page.php" 
      class="bg-[#064089] hover:bg-blue-900 p-3 rounded-md shadow-md transition flex items-center justify-center">
      <img src="resources/svg/back-arrow.svg" alt="Back" class="h-6 w-6">
    </a>

    <!-- Submit -->
    <button type="submit" class="bg-[#064089] hover:bg-blue-900 text-white text-lg font-medium px-8 py-3 rounded-md shadow-md transition">
      Submit
    </button>
  </div>

</form>

    </div>
  </div>

  <!-- Footer (left under the white div) -->
  <div class="w-full max-w-[90%] mx-6 mt-4 mb-10 text-left">
    <p class="text-[#F1F7F9] text-s">
      © University of Rizal System - Customer Satisfaction Survey System
    </p>
  </div>

</div>
