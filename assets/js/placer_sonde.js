function placer_sonde(nom, x, y, z){
  var sondeTexture = new THREE.MeshBasicMaterial({color:"#FFFFFF",wireframe:false});
  var length = nom.match(/\d+/)[0]
  var finalLength = 0;
  length == 70 ? finalLength = 100 : finalLength = 120;
  var sondeGeometry = new THREE.CylinderGeometry(6/2,6/2,finalLength*10, 8, 1);
  var sonde = new THREE.Mesh(sondeGeometry, sondeTexture);
  sonde.position.set(x,y,z);
  sonde.name = "Sonde" + nom;
  scene.add(sonde);
}