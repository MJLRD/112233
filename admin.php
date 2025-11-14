<link rel="stylesheet" href="_unified_assets/unified-style.css">
<script src="_unified_assets/unified-nav.js" defer></script>
<?php
include 'db.php';
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin'){
    header('Location: login.php');
    exit;
}
$alert = '';
// Create admin or user
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['action']) && $_POST['action'] === 'create_user'){
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'user';
        if($username && $password){
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO users (username,password,role) VALUES (?,?,?)');
            $stmt->execute([$username,$hash,$role]);
            $alert = "Usuario creado: $username";
        }
    } elseif(isset($_POST['action']) && $_POST['action'] === 'delete_user') {
        $id = intval($_POST['id']);
        if($id){
            $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
            $stmt->execute([$id]);
            $alert = "Usuario eliminado: $id";
        }
    }
}

$users = $pdo->query('SELECT id,username,role,created_at FROM users ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include 'header.php'; ?>
<div class="card p-3 mb-3">
  <h4>Panel de administración</h4>
  <?php if($alert): ?><div class="alert alert-success"><?php echo htmlspecialchars($alert); ?></div><?php endif; ?>
  <div class="row">
    <div class="col-md-6">
      <h6>Crear cuenta</h6>
      <form method="post">
        <input type="hidden" name="action" value="create_user">
        <div class="mb-2"><input class="form-control" name="username" placeholder="Usuario"></div>
        <div class="mb-2"><input class="form-control" name="password" placeholder="Contraseña"></div>
        <div class="mb-2">
          <select class="form-control" name="role">
            <option value="user">Usuario</option>
            <option value="admin">Administrador</option>
          </select>
        </div>
        <button class="btn btn-primary">Crear</button>
      </form>
    </div>
    <div class="col-md-6">
      <h6>Usuarios (eliminar)</h6>
      <table class="table table-sm">
        <thead><tr><th>ID</th><th>Usuario</th><th>Rol</th><th>Acción</th></tr></thead>
        <tbody>
        <?php foreach($users as $u): ?>
          <tr>
            <td><?php echo $u['id']; ?></td>
            <td><?php echo htmlspecialchars($u['username']); ?></td>
            <td><?php echo $u['role']; ?></td>
            <td>
              <?php if($u['id'] != $_SESSION['user']['id']): ?>
                <form method="post" style="display:inline">
                  <input type="hidden" name="action" value="delete_user">
                  <input type="hidden" name="id" value="<?php echo $u['id']; ?>">
                  <button class="btn btn-sm btn-danger" onclick="return confirm('Eliminar?')">Eliminar</button>
                </form>
              <?php else: ?>
                (tú)
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="card p-3">
  <h6>Ver reseñas</h6>
  <?php $reviews = $pdo->query('SELECT r.id, r.user_id, r.content, r.created_at, u.username FROM reviews r LEFT JOIN users u ON u.id = r.user_id ORDER BY r.id DESC')->fetchAll(PDO::FETCH_ASSOC); ?>
  <table class="table table-sm">
    <thead><tr><th>ID</th><th>Usuario</th><th>Contenido</th><th>Fecha</th></tr></thead>
    <tbody>
    <?php foreach($reviews as $r): ?>
      <tr>
        <td><?php echo $r['id']; ?></td>
        <td><?php echo htmlspecialchars($r['username'] ?? '—'); ?></td>
        <td><?php echo htmlspecialchars($r['content']); ?></td>
        <td><?php echo $r['created_at']; ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php include 'footer.php'; ?>