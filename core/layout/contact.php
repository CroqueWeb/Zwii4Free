<?php
$dest=[];
foreach($this->getData(['user']) as $userId => $user) {
$dest[] = $user['mail'];
}

// Vérification ou création de la session
if (session_id()=='') {
    session_start();
    // Passer $session_mustclose à false si vous ne souhaitez pas fermer la session une fois le mail envoyé.
    // Passez à true si la session doit être fermée.
    $session_mustclose = true;
    }

// Génération d'un token de session
 function generateFormToken($form)
    {
        $token = md5(uniqid(microtime(), true));
        $_SESSION[$form.'_token_form'] = $token;
        return $token;
    }

    function verifyFormToken($form)
    {
        if (!isset($_SESSION[$form.'_token_form']))
        {return false;}
        if (!isset($_POST['token_form']))
        {return false;}
        if ($_SESSION[$form.'_token_form'] !== $_POST['token_form'])
        {return false;}
        return true;
    }

    function checkWhitelist($list)
    {
        foreach ($_POST as $key => $item)
        {
            if (!in_array($key, $list))
            {return false;}
        }
        return true;
    }

// Nouvelle fonction mail pour le FAI Free, conforme au standard
function mailFree($destinataire, $titre, $message, $headers=null , $parameters=null) {
	$start_time = time();
	$resultat=mail ($destinataire, $titre, $message, $headers, $parameters);
	$time= time()-$start_time;
	return $resultat & ($time>1);
}
// Fin de la définition de la fonction

// Destinataire
$destinataire = $this->getData(['config', 'title']) .' <'.$dest[0].'>';

if (isset($_POST['envoyer'])){
// le formulaire a été soumis
$etat = 'erreur';
// Valeur par défaut. Prendra la valeur "ok" s'il n'y a pas d'erreur
// mise en forme des champs saisis dans le formulaire lors de sa soumission
if (isset($_POST['expediteur'])) {
$_POST['expediteur']=trim(strip_tags(stripslashes($_POST['expediteur'])));
}
if (isset($_POST['titre'])) {
$_POST['titre']=trim(strip_tags(stripslashes($_POST['titre'])));
}
if (isset($_POST['message'])) {
$_POST['message']=trim(strip_tags(stripslashes($_POST['message'])));
}
// test de la validité des champs saisis
if (empty($_POST['expediteur'])) {
// il manque l'email de l'expéditeur
$erreur='Saisissez votre adresse email&hellip;';
}
elseif (!preg_match("#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#",$_POST['expediteur']) ){
// l'adresse e-mail n'est pas valide
$erreur='Votre adresse e-mail n\'est pas valide&hellip;';
}
elseif (empty($_POST['message'])) {
// le message est vide
$erreur='Saisissez un message&hellip;';
}

else {
// Vérification du token de session
// Vérification de la validité du formulaire
$whitelist = array('expediteur', 'message', 'titre', 'envoyer', 'annuler', 'control', 'token_form');
if(verifyFormToken('contact_form') && checkWhitelist($whitelist) && $_POST['control'] = 666){
// tous les champs sont correctement remplis: on pourra envoyer le mail ---
$etat='ok';}
// Le code captcha n'est pas valide
else {$erreur='Token de session non valide, réessayez&hellip;';}
}
}

else {
// --- le formulaire n'a pas été soumis ---
$etat='attente';
}

$token = generateFormToken('contact_form');

?>

<script type="text/javascript">
    $(function(){
        $('#expediteur').bind('focus', function(){
            $("#control").val('666');
        });
    });
</script>

<h2>Contacter <?php echo $this->getData(['config', 'title']); ?></h2>
<?php
// le formulaire n'a pas été soumis, ou soumis avec une erreur
if ($etat!='ok'){
//le formulaire a été soumis avec une erreur
if ($etat=='erreur'){
// afficher le message d'erreur
echo '<p><strong style="color:#ff0000">'.$erreur.'</strong></p>';
}
?>
<form method="post" name="contact_form" action="?<?php echo $this->getUrl(0); ?>">
<p><input type="hidden" name="token_form" value="<?php echo $token; ?>"></p>
<p><input type="hidden" name="control" id="control" value="0"></p>
<p><label for="expediteur">Votre adresse e-mail* :</label><br>
<input type="text" maxlength="254" name="expediteur" id="expediteur" value="<?php
if (!empty($_POST['expediteur'])) {
echo stripslashes(htmlspecialchars($_POST['expediteur'],ENT_QUOTES,'UTF-8'));
}
?>">
</p>
<p><label for="titre">Titre du message :</label><br>
<input type="text" maxlength="254" name="titre" id="titre" value="<?php
if (!empty($_POST['titre'])) {
echo stripslashes(htmlspecialchars($_POST['titre'],ENT_QUOTES,'UTF-8'));
}
?>">
</p>
<p><label for="message">Message* :</label><br>
<textarea name="message" id="message" rows="5"><?php
if (isset($_POST['message'])) {
echo stripslashes(htmlspecialchars($_POST['message'],ENT_QUOTES,'UTF-8'));
}
?></textarea>
</p>
<p><input type="submit" name="envoyer" value="Envoyer"> <input type="reset" name="annuler" value="Annuler"></p>
</form>
<small>* Contenu minimum obligatoire</small>
<?php
}
else {

$expediteur = $_POST['expediteur'];
if (empty($_POST['titre'])) {
// le sujet est absent
$titre = 'Contact';
}
else {
$titre = $_POST['titre'];
}
$message = $_POST['message'];

// le formulaire a été soumis sans erreur, on tente d'envoyer le mail
$headers = "Reply-To: $expediteur\r\n";
$headers .= "Content-Type: text/plain; charset=utf-8\r\n";
$headers .= "From: $destinataire\r\n";
$headers .= "Return-Path: $destinataire\r\n";
$headers .= "MIME-Version: 1.0\r\n";
if (mailFree($destinataire, $titre, $message, $headers)==false){
// erreur lors de l'envoi du mail
echo '<p>Un problème s\'est produit lors de l\'envoi du message et il n\'a pas pu être envoyé.<br><a href=".">Réessayez&hellip;</a><p>';
}
else {
// mail envoyé
echo '<h3>Merci !</h3><p>Votre message a été envoyé.</p>';
// On efface et détruit les varaibles de sessions
if (isset($session_mustclose)) {
        session_unset();
        session_destroy();
    }
}
}
?>
