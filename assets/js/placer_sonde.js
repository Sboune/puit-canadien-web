function placer_sonde(nom, x, y, z, r, g, b) {
  var sondeGeo = new THREE.SphereGeometry(8, 32, 16);  
  var sondeMat = new THREE.MeshLambertMaterial({ color: "rgb("+r+","+g+","+b+")" });
  var sonde = new THREE.Mesh(sondeGeo, sondeMat);
  sonde.position.set(x/2, (y/2)-XOFFSET, z/2);
  sonde.name = "Sonde " + nom;
  scene.add(sonde);

  targetList.push(sonde);
}