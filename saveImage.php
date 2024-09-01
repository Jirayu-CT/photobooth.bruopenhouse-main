<?php
if (isset($_POST['image'])) {
    $imageData = $_POST['image'];

    // แปลง base64 เป็นรูปภาพ
    $imageData = str_replace('data:image/jpeg;base64,', '', $imageData);
    $imageData = str_replace(' ', '+', $imageData);
    $decodedData = base64_decode($imageData);

    // ตรวจสอบและสร้างโฟลเดอร์ cameraImage ถ้ายังไม่มี
    $folderPath = 'cameraImage/';
    if (!is_dir($folderPath)) {
        mkdir($folderPath, 0777, true);
    }

    // สร้างชื่อไฟล์แบบสุ่ม
    $fileName = uniqid() . '.jpg';

    // บันทึกภาพลงในโฟลเดอร์
    $filePath = $folderPath . $fileName;
    if (file_put_contents($filePath, $decodedData)) {
        // ส่งข้อความสำเร็จกลับไปยัง JavaScript
        echo json_encode(['status' => 'success', 'file' => $fileName]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ไม่สามารถบันทึกภาพได้']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ไม่มีข้อมูลภาพ']);
}
?>
