function placer_capteur_sonde(nom, idC, idD, x, y, z, r, g, b) {
  var capteurGeometry = new THREE.SphereGeometry(7, 32, 16);  
  var capteurTexture = new THREE.MeshBasicMaterial({ color: "rgb("+r+","+g+","+b+")" });
  var capteur = new THREE.Mesh(capteurGeometry, capteurTexture);
  capteur.position.set(x, y-200, z);
  capteur.name = "Capteur " + nom;
  capteur.idC = idC;
  capteur.idD = idD;
  scene.add(capteur);
  
  targetList.push(capteur);
}