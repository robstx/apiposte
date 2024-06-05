<?php

// Inclui o arquivo DbOperation.php da pasta includes
require_once '../includes/DbOperation.php';

// Função para verificar se parâmetros necessários estão presentes
function isTheseParametersAvailable($params) {
  $available = true;
  $missingParams = "";

  foreach ($params as $param) {
    if (!isset($_POST[$param]) || strlen(trim($_POST[$param])) <= 0) {
      $available = false;
      $missingParams .= ", " . $param;
    }
  }

  if (!$available) {
    $response = array();
    $response['error'] = true;
    $response['message'] = 'Parâmetros ' . substr($missingParams, 1) . ' ausentes';

    echo json_encode($response);

    die();
  }
}

// Array para armazenar a resposta da API
$response = array();

// Verifica se a chamada da API é válida (se o parâmetro "apicall" está definido)
if (isset($_GET['apicall'])) {

  switch ($_GET['apicall']) {

    case 'createPoste': // Substituído 'createhero' por 'createPoste' para adequar ao contexto

      // Verifica se os parâmetros necessários estão presentes
      isTheseParametersAvailable(array('localizacao', 'status', 'ultima_manutencao', 'distrito', 'zona'));

      // Cria uma instância da classe DbOperation
      $db = new DbOperation();

      // Chama o método createPoste para criar um novo poste
      $result = $db->createPoste(
        $_POST['localizacao'],
        $_POST['status'],
        $_POST['ultima_manutencao'],
        $_POST['distrito'],
        $_POST['zona']
      );

      if ($result) {
        $response['error'] = false;
        $response['message'] = 'Poste adicionado com sucesso';
        $response['postes'] = $db->getPostes(); // Substitui 'heroes' por 'postes' para adequar ao contexto
      } else {
        $response['error'] = true;
        $response['message'] = 'Algum erro ocorreu. Por favor, tente novamente.';
      }

      break;

    case 'getPostes': // Substituído 'getheroes' por 'getPostes' para adequar ao contexto

      $db = new DbOperation();
      $response['error'] = false;
      $response['message'] = 'Solicitação concluída com sucesso';
      $response['postes'] = $db->getPostes(); // Substitui 'heroes' por 'postes' para adequar ao contexto

      break;

    case 'updatePoste': // Substituído 'updatehero' por 'updatePoste' para adequar ao contexto

      // Verifica se os parâmetros necessários estão presentes
      isTheseParametersAvailable(array('id', 'localizacao', 'status', 'ultima_manutencao', 'distrito', 'zona'));

      $db = new DbOperation();
      $result = $db->updatePoste(
        $_POST['id'],
        $_POST['localizacao'],
        $_POST['status'],
        $_POST['ultima_manutencao'],
        $_POST['distrito'],
        $_POST['zona']
      );

      if ($result) {
        $response['error'] = false;
        $response['message'] - 'Poste atualizado com sucesso';
        $response['postes'] = $db->getPostes(); // Substitui 'heroes' por 'postes' para adequar ao contexto
      } else {
        $response['error'] = true;
        $response['message'] = 'Algum erro ocorreu. Por favor, tente novamente.';
      }

      break;

    case 'deletePoste': // Substituído 'deletehero' por 'deletePoste' para adequar ao contexto

      if (isset($_GET['id'])) {
        $db = new DbOperation();
        if ($db->deletePoste($_GET['id'])) {
          $response['error'] = false;
          $response['message'] = 'Poste excluído com sucesso';
          $response['postes'] = $db->getPostes(); // Substitui 'heroes' por 'postes' para adequar ao contexto
        }
