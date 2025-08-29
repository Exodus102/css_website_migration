<div class="h-screen flex flex-col items-center justify-between relative bg-cover bg-center"
  style="background-image: url('resources/svg/landing-page.svg');">

<!-- Logo -->
<div class="flex items-center justify-center gap-2 mb-4 mt-10">
  <img src="resources/svg/logo.svg" alt="URSatisfaction Logo" class="h-16">
  <div class="text-left">
    <h2 class="text-xl font-bold leading-tight">
      <span class="text-[#95B3D3]">URS</span><span class="text-[#F1F7F9]">atisfaction</span>
    </h2>
    <p class="text-sm text-[#F1F7F9] leading-snug">We comply so URSatisfied</p>
  </div>
</div>


  <!-- White Card -->
  <div class="bg-white shadow-2xl rounded-lg w-full max-w-[90%] p-10 mx-6 min-h-[550px] flex items-center">
    <!-- Inner wrapper -->
    <div class="w-full max-w-xl mx-auto space-y-10 px-10">

      <!-- Title -->
      <div class="text-left">
        <h1 class="text-2xl font-bold text-[#1E1E1E] mb-2 leading-snug">Getting started!</h1>
        <p class="text-sm text-[#1E1E1E] leading-relaxed max-w-[90%]">
          Help us understand what are we working on today by providing the following information:
        </p>
      </div>

      <!-- Form -->
      <form action="pages/dynamic_page.php" method="POST" class="space-y-6">

        <!-- Transaction Type -->
        <div>
          <label class="block text-[#1E1E1E] text-sm mb-2 leading-snug">Transaction Type <span class="text-red-500">*</span></label>
          <div class="space-y-2">
            <label class="flex items-center space-x-2">
              <input type="radio" name="transaction_type" value="Face-to-Face" 
                     class="text-[#064089] focus:ring-[#064089] w-4 h-4" required>
              <span class="text-sm text-[#1E1E1E] leading-relaxed">Face-to-Face</span>
            </label>
            <label class="flex items-center space-x-2">
              <input type="radio" name="transaction_type" value="Online" 
                     class="text-[#064089] focus:ring-[#064089] w-4 h-4" required>
              <span class="text-sm text-[#1E1E1E] leading-relaxed">Online</span>
            </label>
          </div>
        </div>

        <!-- Purpose of Visit -->
        <div>
          <label class="block text-[#1E1E1E] text-sm mb-2 leading-snug">Purpose of Visit or Transaction <span class="text-red-500">*</span></label>
          <textarea
            name="purpose"
            rows="3"
            class="w-full border border-[#1E1E1E] rounded-md px-3 py-2 text-sm text-[#1E1E1E] leading-relaxed focus:outline-none focus:ring-2 focus:ring-[#064089]"
            placeholder="Enter purpose here..."
            required></textarea>
        </div>

        <!-- Button -->
        <div class="flex justify-end">
          <button type="submit" class="bg-[#064089] hover:bg-blue-900 text-white text-sm font-medium px-6 py-2 rounded-md shadow-md transition">
            Evaluate
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
