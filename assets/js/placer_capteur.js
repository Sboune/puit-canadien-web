function placer_capteur(nom, idC, idD, x, y, z, r, g, b) {
  var sondeGeo = new THREE.SphereGeometry(7, 32, 16);  
  var sondeMat = new THREE.MeshBasicMaterial({ color: "rgb("+r+","+g+","+b+")" });
  var sonde = new THREE.Mesh(sondeGeo, sondeMat);
  sonde.position.set(x/2, (y/2)-XOFFSET, z/2);
  sonde.name = "Sonde " + nom;
  sonde.idC = idC;
  sonde.idD = idD;
  scene.add(sonde);

  targetList.push(sonde);
}