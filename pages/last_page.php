<div class="min-h-screen flex flex-col items-center justify-start relative bg-cover bg-center" 
     style="background-image: url('resources/svg/landing-page.svg');">

  <!-- Logo -->
  <div class="flex items-center justify-center gap- mb-10 mt-6">
    <img src="resources/svg/logo.svg" alt="URSatisfaction Logo" class="h-20">
    <div class="text-left">
      <h2 class="text-2xl font-bold leading-tight">
        <span class="text-[#95B3D3]">URS</span><span class="text-[#F1F7F9]">atisfaction</span>
      </h2>
      <p class="text-sm text-[#F1F7F9] leading-snug">We comply so URSatisfied</p>
    </div>
  </div>

  <!-- White Card -->
  <div class="bg-white shadow-2xl rounded-lg w-full max-w-[90%] p-14 mx-6 min-h-[680px] mt-14">
    <!-- Inner wrapper with extra padding -->
    <div class="w-full max-w-2xl mx-auto space-y-10 px-10">

      <!-- Title -->
      <div class="text-left">
        <h1 class="text-3xl font-bold text-[#1E1E1E] mb-3 leading-snug">Getting started!</h1>
        <p class="text-lg text-[#1E1E1E] leading-relaxed">
          Help us understand what are we working on today by providing the following information:
        </p>
      </div>

      <!-- Form -->
      <form action="process.php" method="POST" class="space-y-8">
        
        <!-- Transaction Type -->
        <div>
          <label class="block text-[#1E1E1E] text-lg mb-3 leading-snug">Transaction Type</label>
          <div class="space-y-3">
            <label class="flex items-center space-x-2">
              <input type="radio" name="transaction_type" value="Face-to-Face" class="text-[#064089] focus:ring-[#064089] w-5 h-5">
              <span class="text-lg text-[#1E1E1E] leading-relaxed">Face-to-Face</span>
            </label>
            <label class="flex items-center space-x-2">
              <input type="radio" name="transaction_type" value="Online" class="text-[#064089] focus:ring-[#064089] w-5 h-5">
              <span class="text-lg text-[#1E1E1E] leading-relaxed">Online</span>
            </label>
          </div>
        </div>

        <!-- Purpose of Visit -->
        <div>
          <label class="block text-[#1E1E1E] text-lg mb-3 leading-snug">Purpose of Visit or Transaction</label>
          <textarea 
            name="purpose" 
            rows="4" 
            class="w-full border border-[#1E1E1E] rounded-md px-4 py-3 text-lg text-[#1E1E1E] leading-relaxed focus:outline-none focus:ring-2 focus:ring-[#064089]"
            placeholder="Enter purpose here..."
          ></textarea>
        </div>

        <!-- Button -->
        <div class="flex justify-end">
          <button type="submit" class="bg-[#064089] hover:bg-blue-900 text-white text-lg font-medium px-8 py-3 rounded-md shadow-md transition">
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
