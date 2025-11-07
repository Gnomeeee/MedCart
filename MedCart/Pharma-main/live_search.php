<?php
require_once './includes/db.inc.php';

if (isset($_GET['query'])) {
    $search = trim($_GET['query']);
    
    // Ensure the search query is at least 1 character long
    if (strlen($search) < 1) {
        echo json_encode([]); // Return empty array if query is too short
        exit;
    }

    // Prepare SQL statement with safe binding
    $stmt = $conn->prepare("SELECT item_id, item_title, item_price, item_image FROM item WHERE item_title LIKE CONCAT('%', ?, '%') LIMIT 10");
    
    if ($stmt === false) {
        // Handle statement preparation error
        echo json_encode(['error' => 'SQL preparation failed']);
        exit;
    }
    
    $stmt->bind_param("s", $search); // Bind query parameter
    $stmt->execute(); // Execute the query
    
    $result = $stmt->get_result();
    
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = [
            'id' => $row['item_id'],
            'title' => $row['item_title'],
            'price' => number_format($row['item_price'], 2),  // Format price as needed
            'image' => '../Pharma-main/images/' . basename($row['item_image']) // Adjust image path as needed
        ];
    }

    // Close the statement and connection for security
    $stmt->close();

    // Return the products in JSON format
    header('Content-Type: application/json');
    echo json_encode($products);
} else {
    // If no query, return empty array
    echo json_encode([]);
}
?>
