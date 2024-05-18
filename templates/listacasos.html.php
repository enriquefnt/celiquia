


<div class="container mt-4">
  <table id="example" class="table table-bordered display compact">
    <thead >
  <tr >
  <th align="center">Fecha</th>
  <th align="center">Notifica</th>
    <th align="center">Nombre</th>
    <th align="center">Edad</th>
    <th align="center">Localidad</th> 
    <th class="text-center">Ver/Imprimir</th> 
    </tr>
</thead>

 <tbody>
  <tr>
    <?php foreach($variables['casos'] as $caso): ?>
      <td><?= $caso['fechanot']; ?></td>
    <td><?= $caso['institucion']; ?></td>
    <td><?= htmlspecialchars($caso['nombres'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?= $caso['edad']; ?></td>
    <td><?= $caso['localidad']; ?></td>
    
       <td class="text-center">
        <!-- <a href="/ficha/print?idficha=<?= $caso['idficha'] ?>" target="_blank"><i class="fa-regular fa-file-pdf"></i> -->
        <a href="/ficha/print?idficha=<?= $caso['idficha'] ?>&nombre=<?= urlencode($caso['nombre']) ?>" target="_blank"><i class="fa-regular fa-file-pdf"></i></a>

       </a>
      
      </td> 
   
  </tr>
  <?php endforeach; ?>
  </tbody>
  </table>
</div>