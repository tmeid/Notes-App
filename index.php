<?php
    require 'post.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Note</title>
</head>

<body>
    <div class="container">
        <h1>Note</h1>
        <form action="index.php" method="POST" class="add-note">
            <input type="hidden" name="id" value="<?php echo $db->record['id'] ?>">
            <label for="title">Tiêu đề</label>
            <input type="text" id="title" placeholder="Nhập tiêu đề" name="title" 
                value="<?php echo $db->record['title']?>"
            >
            <label for="content">Nội dung</label>
            <textarea name="content" id="content" cols="30" rows="4" placeholder="Nhập ghi chú"><?php echo $db->record['content']?></textarea>
            <button type="submit" name="<?php echo !empty($_GET['id']) ? 'edit-btn' : 'btn' ?>" class="btn">
                <?php echo !empty($_GET['id']) ? 'Sửa note' : 'Thêm note' ?>
            </button>
        </form>
        <div class="notes">
            <?php
                foreach($notes as $note):
            ?>
                <div class="note">
                    <h2 class="name"><a href="?id=<?php echo $note['id'] ?>"><?php echo $note['title'] ?></a></h2>
                    <p><?php echo $note['content'] ?></p>
                    <span><?php echo date('j/n/Y', strtotime($note['created_at'])) ?></span>
                    <form action="index.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $note['id'] ?>">
                        <button class="delete-btn" name="delete-btn">X</button>
                    </form>
                    
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>

</html>