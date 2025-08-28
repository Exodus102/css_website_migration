<?php
require_once '../../auth/_dbConfig/_dbConfig.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve submitted data
    $transactionType = isset($_POST['transaction_type']) ? $_POST['transaction_type'] : null;
    $purpose = isset($_POST['purpose']) ? trim($_POST['purpose']) : null;
    $answers = isset($_POST['answers']) ? $_POST['answers'] : [];

    // Validate that we have answers to process
    if (empty($answers) || $transactionType === null || $purpose === null) {
        header("Location: first_page.php");
        exit();
    }

    // Start a transaction for data integrity
    $conn->begin_transaction();

    try {
        // Step 1: Insert the purpose as the first record to generate a unique ID.
        // We'll use this ID as the `response_id` for all answers.
        $purpose_question_id = 1; // 💡 The purpose is treated as a response to a specific question (e.g., Question #1).
        $purpose_response = $purpose;

        // Get the header value for the purpose question from the tbl_questionaire table.
        $stmt_header = $conn->prepare("SELECT header FROM tbl_questionaire WHERE question_id = ?");
        $stmt_header->bind_param("i", $purpose_question_id);
        $stmt_header->execute();
        $header_result = $stmt_header->get_result();
        $header_row = $header_result->fetch_assoc();
        $header_value = $header_row ? $header_row['header'] : null;
        $stmt_header->close();

        $stmt_purpose = $conn->prepare(
            "INSERT INTO tbl_responses (question_id, response, header, transaction_type) VALUES (?, ?, ?, ?)"
        );
        if ($stmt_purpose === false) {
            throw new Exception('Database prepare failed for purpose insert: ' . $conn->error);
        }

        $stmt_purpose->bind_param("isss", $purpose_question_id, $purpose_response, $header_value, $transactionType);
        $stmt_purpose->execute();

        // Get the auto-generated `id` from the purpose insert. This is our `response_id`.
        $response_id = $conn->insert_id;
        if ($response_id === 0) {
            throw new Exception("Failed to get auto-generated ID from the purpose insert.");
        }

        // Update the first record (the purpose) to set its `response_id` to the ID we just generated.
        $stmt_update = $conn->prepare("UPDATE tbl_responses SET response_id = ? WHERE id = ?");
        $stmt_update->bind_param("ii", $response_id, $response_id);
        $stmt_update->execute();
        $stmt_update->close();

        // Step 2: Loop through the remaining answers and insert them with the same `response_id`.
        $stmt_rest = $conn->prepare(
            "INSERT INTO tbl_responses (response_id, question_id, response, header, transaction_type) VALUES (?, ?, ?, ?, ?)"
        );
        if ($stmt_rest === false) {
            throw new Exception('Database prepare for subsequent inserts failed: ' . $conn->error);
        }

        foreach ($answers as $q_id => $resp) {
            $question_id = $q_id;
            $response = is_array($resp) ? implode(', ', $resp) : $resp;

            // Get the header value for the current question from the tbl_questionaire table.
            $stmt_header_rest = $conn->prepare("SELECT header FROM tbl_questionaire WHERE question_id = ?");
            $stmt_header_rest->bind_param("i", $question_id);
            $stmt_header_rest->execute();
            $header_result_rest = $stmt_header_rest->get_result();
            $header_row_rest = $header_result_rest->fetch_assoc();
            $header_value_rest = $header_row_rest ? $header_row_rest['header'] : null;
            $stmt_header_rest->close();

            // Bind all parameters for the current record.
            $stmt_rest->bind_param("iisss", $response_id, $question_id, $response, $header_value_rest, $transactionType);
            $stmt_rest->execute();
        }

        $stmt_purpose->close();
        $stmt_rest->close();
        $conn->commit();

        header("Location: ../../pages/last_page.php");
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        die('An error occurred during transaction: ' . $e->getMessage());
    } finally {
        $conn->close();
    }
} else {
    header("Location: first_page.php");
    exit();
}
