function placer_corbeille(nom, x, y, z) {
  var Geo = new THREE.CylinderGeometry(6/2, 6/2, 400/2, 8/2, 1, true); 
  var Mat = new THREE.MeshBasicMaterial({ color:"rgb(255,255,255)", wireframe:false })
  var corb = new THREE.Mesh(Geo, Mat);
  corb.name = "Corbeille "+nom;
  corb.position.set(x/2, (y/2)-XOFFSET, z/2);
  scene.add(corb);
}