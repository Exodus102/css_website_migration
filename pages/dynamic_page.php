<?php
// It's a good practice to check if the form was submitted via POST
require_once '../auth/_dbConfig/_dbConfig.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Use isset() to avoid errors if a value wasn't submitted
  $transactionTypeString = isset($_POST['transaction_type']) ? $_POST['transaction_type'] : 'Not provided';
  $purpose = isset($_POST['purpose']) ? trim($_POST['purpose']) : 'Not provided';

  // Map transaction type to numeric value for the next page
  $transactionType = 'Not provided';
  if ($transactionTypeString === 'Face-to-Face') {
    $transactionType = 0;
  } elseif ($transactionTypeString === 'Online') {
    $transactionType = 1;
  }

  // Use htmlspecialchars() to prevent XSS when displaying user input
  $safeTransactionType = htmlspecialchars($transactionType, ENT_QUOTES, 'UTF-8');
  $safePurpose = htmlspecialchars($purpose, ENT_QUOTES, 'UTF-8');
} else {
  // If the page is accessed directly, redirect to the first page
  header("Location: first_page.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../Tailwind/src/output.css">
  <title>Customer Satisfaction Survey</title>
</head>

<body>
  <div class="min-h-screen flex flex-col items-center justify-start relative bg-cover bg-center"
    style="background-image: url('../resources/svg/landing-page.svg');">

    <!-- Logo -->
    <div class="flex items-center justify-center gap- mb-5 mt-6">
      <img src="../resources/svg/logo.svg" alt="URSatisfaction Logo" class="h-20">
      <div class="text-left">
        <h2 class="text-2xl font-bold leading-tight">
          <span class="text-[#95B3D3]">URS</span><span class="text-[#F1F7F9]">atisfaction</span>
        </h2>
        <p class="text-sm text-[#F1F7F9] leading-snug">We comply so URSatisfied</p>
      </div>
    </div>

    <!-- White Card -->
    <div class="bg-white shadow-2xl rounded-lg w-full max-w-[90%] p-14 mx-6 min-h-[620px] mt-14">
      <!-- Inner wrapper with extra padding -->
      <div class="w-full max-w-2xl mx-auto space-y-10 px-10">
        <!-- Form -->
        <form action="../function/_processAnswer/_processAnswer.php" method="POST" class="space-y-8">
          <!-- Hidden fields to pass data to the next page -->
          <input type="hidden" name="transaction_type" value="<?= $safeTransactionType ?>">
          <input type="hidden" name="purpose" value="<?= $safePurpose ?>">

          <!-- Questions from Database -->
          <div class="space-y-8 border-t pt-8">
            <?php
            // Prepare and execute the query to get questions
            // Using prepared statements to prevent SQL injection.
            // Fetch questions for the selected type (0 or 1) AND for type 2 (common questions).
            $stmt = $conn->prepare("SELECT question_id, question, question_type, required FROM tbl_questionaire WHERE (transaction_type = ? OR transaction_type = 2) AND status = 1 ORDER BY question_id");
            $stmt->bind_param("i", $transactionType);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
              while ($question = $result->fetch_assoc()) {
                $q_id = htmlspecialchars($question['question_id']);
                $q_text = htmlspecialchars($question['question']);
                $q_type = $question['question_type'];
                $q_required = $question['required'] ? 'required' : '';

                echo "<div class='space-y-3 animate-fade-in'>";
                echo "<label class='block text-[#1E1E1E] text-lg leading-snug font-medium'>{$q_text}</label>";

                // Render input based on question_type
                switch ($q_type) {
                  case 'Dropdown':
                    $choice_stmt = $conn->prepare("SELECT choice_text FROM tbl_choices WHERE question_id = ? ORDER BY choices_id");
                    $choice_stmt->bind_param("i", $question['question_id']);
                    $choice_stmt->execute();
                    $choices_result = $choice_stmt->get_result();

                    echo "<select name='answers[{$q_id}]' class='mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-[#064089] focus:border-[#064089] sm:text-lg rounded-md' {$q_required}>";
                    echo "<option value='' disabled selected>--Please choose an option--</option>";

                    while ($choice = $choices_result->fetch_assoc()) {
                      $c_text = htmlspecialchars($choice['choice_text']);
                      echo "<option value='{$c_text}'>{$c_text}</option>";
                    }

                    echo "</select>";
                    $choice_stmt->close();
                    break;
                  case 'Multiple Choice':
                    $choice_stmt = $conn->prepare("SELECT choice_text FROM tbl_choices WHERE question_id = ? ORDER BY choices_id");
                    $choice_stmt->bind_param("i", $question['question_id']);
                    $choice_stmt->execute();
                    $choices_result = $choice_stmt->get_result();

                    echo "<div class='mt-2 flex items-center space-x-6'>";
                    $choice_index = 0;
                    while ($choice = $choices_result->fetch_assoc()) {
                      $c_text = htmlspecialchars($choice['choice_text']);
                      $radio_id = "q_{$q_id}_choice_{$choice_index}";
                      echo "<div class='flex items-center'>";
                      echo "<input id='{$radio_id}' name='answers[{$q_id}]' type='radio' value='{$c_text}' class='focus:ring-[#064089] h-4 w-4 text-[#064089] border-gray-300' {$q_required}>";
                      echo "<label for='{$radio_id}' class='ml-3 block text-base text-gray-700'>{$c_text}</label>";
                      echo "</div>";
                      $choice_index++;
                    }
                    echo "</div>";
                    $choice_stmt->close();
                    break;
                  case 'Description':
                    // This is just a label, no input required.
                    break;
                  case 'Text':
                    echo "<input type='text' name='answers[{$q_id}]' class='mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-[#064089] focus:border-[#064089] sm:text-lg rounded-md' {$q_required}>";
                    break;
                }
                echo "</div>";
              }
            } else {
              echo "<p class='text-red-600 text-center'>No questions found for this transaction type.</p>";
            }
            $stmt->close();
            $conn->close();
            ?>
          </div>

          <!-- Buttons -->
          <div class="flex justify-between items-center">
            <!-- Back Arrow -->
            <a href="javascript:history.back()"
              class="bg-[#064089] hover:bg-blue-900 p-3 rounded-md shadow-md transition flex items-center justify-center">
              <img src="../resources/svg/back-arrow.svg" alt="Back" class="h-6 w-6">
            </a>

            <!-- Submit -->
            <button type="submit" class="bg-[#064089] hover:bg-blue-900 text-white text-lg font-medium px-8 py-3 rounded-md shadow-md transition">
              Next
            </button>
          </div>

        </form>

      </div>
    </div>

    <!-- Footer (left under the white div) -->
    <div class="w-[90%] max-w-4xl mx-6 mt-4 mb-10 text-left">
      <p class="text-[#F1F7F9] text-sm">
        © University of Rizal System - Customer Satisfaction Survey System
      </p>
    </div>

  </div>

</body>

</html>