<h2>Quản lý bình luận</h2>
<form method="get" action="index.php">
    <input type="hidden" name="act" value="admin-comment-list">
    <div class="input-group mb-3">
        <input
            type="text"
            name="q"
            class="form-control"
            placeholder="Tìm binh luan..."
            value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
        <button class="btn btn-outline-secondary" type="submit">Tìm</button>
    </div>
</form>
<table border="1" width="100%" cellpadding="6" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Người dùng</th>
            <th>Sản phẩm</th>
            <th>Nội dung</th>
            <th>Ngày</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($comments as $bl): ?>
            <tr>
                <td><?= $bl['MaBinhLuan'] ?></td>
                <td><?= htmlspecialchars($bl['TenDangNhap']) ?></td>
                <td><?= htmlspecialchars($bl['TenSanPham']) ?></td>
                <td><?= htmlspecialchars($bl['NoiDung']) ?></td>
                <td><?= $bl['NgayBinhLuan'] ?></td>
                <td>
                    <a class="btn btn-sm btn-warning me-1" href="index.php?act=admin-comment-delete&id=<?= $bl['MaBinhLuan'] ?>"
                        onclick="return confirm('Xoá bình luận này?')">
                        Xoá
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>