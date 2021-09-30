<?php $v->layout('_theme_admin'); ?>

<?php
if (count($message) > 0) {
  foreach ($message as $arr) {    
    if (!isset($arr['texto'])) continue;
    $classe = ($arr["tipo"] == "erro") ? "alert-danger" : "alert-success";
?>
    <div class="alert <?= $classe ?> d-flex align-items-center" role="alert">
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
      <div>
      <?= $arr['texto'] ?>
      </div>
    </div>
<?php
  }
}
  $ingredientes_str = "";
  if (isset($ingredientes)) {
    $size = count($ingredientes);
    for($i = 0; $i < $size; $i++) {
      $ingredientes_str .= $ingredientes[$i]->descricao;
      if ($i < $size - 1) $ingredientes_str .= ';';
    }
  }

  $passos_str = "";
  if (isset($passos)) {
    $size = count($passos);
    for($i = 0; $i < $size; $i++) {
      $passos_str .= $passos[$i]->descricao;
      if ($i < $size - 1) $passos_str .= ';';
    }
  }
  $url = isset($table) ? "admin/receita/atualizar/".$table->id
    : "admin/receita/criar";
?>


<form class="px-4 py-4" method="POST" action="<?= url($url) ?>">
  <div class="mb-3">
    <label for="titulo">Título</label> 
    <input value="<?= $table->titulo ?? '' ?>" id="titulo" 
      name="titulo" placeholder="Título da Receita" type="text" required="required" class="form-control">
  </div>
  <div class="mb-3">
    <label for="tempo_preparo">Tempo de Preparo</label> 
    <input min="1" value="<?= $table->tempo_preparo ?? '1' ?>" id="tempo_preparo" 
      name="tempo_preparo" placeholder="Tempo de preparo em minutos" type="number" required="required" 
      class="form-control">
  </div>
  <div class="mb-3">
    <label for="tempo_cozimento">Tempo de Cozimento</label> 
    <input min="1" value="<?= $table->tempo_cozimento ?? '1' ?>" id="tempo_cozimento" 
      name="tempo_cozimento" placeholder="Tempo de cozimento em minutos" type="number" required="required" 
      class="form-control">
  </div> 
  <div class="mb-3">
    <label for="ingredientes">Ingredientes (Cada ingrediente deve ser separado com ponto-e-vírgula)</label> 
    <input value="<?= $ingredientes_str ?>" id="ingredientes" name="ingredientes" 
      placeholder="Ingredientes separados por ponto-e-vírgula" type="text" required="required" class="form-control">
  </div> 
  <div class="mb-3">
    <label for="modo">Modo de Preparo (Cada passo deve ser separado com ponto-e-vírgula)</label> 
    <input value="<?= $passos_str ?>" id="modo" name="modo" placeholder="Passo separado por ponto-e-vírgula" 
      type="text" required="required" class="form-control">
  </div> 
  <div class="mb-3">
    <button name="submit" type="submit" class="btn btn-primary">Salvar</button>
  </div>
</form>