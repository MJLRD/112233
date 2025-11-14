<link rel="stylesheet" href="_unified_assets/unified-style.css">
<script src="_unified_assets/unified-nav.js" defer></script>
<?php
include 'db.php';
session_start();
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user'])){
    $content = $_POST['content'] ?? '';
    if($content){
        $stmt = $pdo->prepare('INSERT INTO reviews (user_id,content,created_at) VALUES (?,?,NOW())');
        $stmt->execute([$_SESSION['user']['id'],$content]);
    }
    header('Location: reviews.php');
    exit;
}
$reviews = $pdo->query('SELECT r.*, u.username FROM reviews r LEFT JOIN users u ON u.id = r.user_id ORDER BY r.id DESC')->fetchAll(PDO::FETCH_ASSOC);
include 'header.php';
?>
<div class="card p-3">
  <h4>Reseñas</h4>
  <?php if(isset($_SESSION['user'])): ?>
    <form method="post" class="mb-3">
      <textarea class="form-control mb-2" name="content" placeholder="Escribe tu reseña"></textarea>
      <button class="btn btn-primary">Publicar</button>
    </form>
  <?php else: ?>
    <p><a href="login.php">Inicia sesión</a> para escribir reseñas.</p>
  <?php endif; ?>
  <ul class="list-group">
  <?php foreach($reviews as $r): ?>
    <li class="list-group-item">
      <strong><?php echo htmlspecialchars($r['username'] ?? 'Invitado'); ?></strong>
      <div><?php echo nl2br(htmlspecialchars($r['content'])); ?></div>
      <small class="text-muted"><?php echo $r['created_at']; ?></small>
    </li>
  <?php endforeach; ?>
  </ul>
</div>
<?php include 'footer.php'; ?>