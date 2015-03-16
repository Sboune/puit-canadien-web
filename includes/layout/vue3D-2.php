<!DOCTYPE html>
<html lang="fr">
  <head>
    <title>vue 3D</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <style>
      body {
        font-family: Monospace;
        background-color: #f0f0f0;
        margin: 0px;
        overflow: hidden;
      }
      .sonde-label {
        position: absolute;
        background-color: white;
        padding: 4px;
        font-family: "Gotham-Book", "HelveticaNeue", "Helvetica Neue", Helvetica, Arial, sans-serif;
        font-size: 14px;
      }
    </style>
  </head>
  <body>
    <div id="container">
      <div id="3Dlabel" class="sonde-label"></div>
    </div>
    
    <script src="../../assets/vendor/jquery/jquery-1.9.1.js"></script>
    <script src="../../assets/vendor/threejs/three.min.js"></script>
    <script src="../../assets/vendor/threejs/Detector.js"></script>
    <script src="../../assets/vendor/threejs/OrbitControls.js"></script>
    <script>
      var container;
      var camera, controls, scene, renderer;
      var targetList = [];
      var selected = new Array();
      var XOFFSET = 150;

      var raycaster = new THREE.Raycaster();
      var mouse = new THREE.Vector2();

      var label, labelIntersected;

      init();
      animate();

      function init() {
        container = document.getElementById("container");
        label = document.getElementById("3Dlabel");

        camera = new THREE.PerspectiveCamera(40, window.innerWidth / window.innerHeight, 1, 10000);
        camera.position.z = 1200;
        camera.position.y = 150;

        controls = new THREE.OrbitControls( camera );
        controls.damping = 1;
        controls.zoomSpeed = 0.5;
        controls.addEventListener( 'change', render );

        scene = new THREE.Scene();

        var light = new THREE.PointLight(0xffffff);
        light.position.set(0, 250, 1000);
        scene.add(light);

        /* GTE côté */
        var textureGTE = THREE.ImageUtils.loadTexture('../../assets/images/GTE.jpg');
        var GTEMaterial = new THREE.MeshBasicMaterial({map: textureGTE, side: THREE.DoubleSide});
        var GTEGeometry = new THREE.PlaneBufferGeometry (500, 210);
        var GTE = new THREE.Mesh(GTEGeometry, GTEMaterial);
        GTE.position.set(500,105,0);
        GTE.rotation.y = -Math.PI / 2;
        scene.add(GTE);

        /* GTE angle*/
        var GTEGeometry2 = new THREE.PlaneBufferGeometry (300, 210);
        var GTE2 = new THREE.Mesh(GTEGeometry2, GTEMaterial);
        GTE2.position.set(650,105,250);

        scene.add(GTE2); 

        /* Chemin côté */
        var textureChemin = new THREE.MeshBasicMaterial({color:"#CFD19C", side: THREE.DoubleSide});
        var cheminGeometry = new THREE.PlaneBufferGeometry(100, 500);
        var chemin = new THREE.Mesh(cheminGeometry, textureChemin);
        chemin.position.set(450,0,0);
        chemin.rotation.x = Math.PI / 2;
        scene.add(chemin);

        /* Chemin devant */
        var cheminGeometry2 = new THREE.PlaneBufferGeometry(1200, 100);
        var chemin2 = new THREE.Mesh(cheminGeometry2, textureChemin);
        chemin2.position.set(200,0,300);
        chemin2.rotation.x = Math.PI / 2;
        
        scene.add(chemin2);

        /* Terrain */
        var textureTerrain = new THREE.MeshBasicMaterial({color:"rgb(127,221,76)", side: THREE.DoubleSide, transparent: true, opacity: 0.5});
        var terrainGeometry = new THREE.PlaneBufferGeometry(800, 500);
        var terrain = new THREE.Mesh(terrainGeometry, textureTerrain);
        terrain.position.set(0,0,0);
        terrain.rotation.x = Math.PI / 2;
        scene.add(terrain);

        /* Fond vertical */
        var fondTexture = new THREE.MeshBasicMaterial({color:"#8B806C", side: THREE.DoubleSide});
        var fondGeometry = new THREE.PlaneBufferGeometry(800, 1220);
        var fond = new THREE.Mesh(fondGeometry, fondTexture);
        fond.position.set(0,-610,-250);
        scene.add(fond);

        /* Fond côté gauche */
        var fondGeometry2 = new THREE.PlaneBufferGeometry(500, 1220);
        var fond2 = new THREE.Mesh(fondGeometry2, fondTexture);
        fond2.position.set(-400,-610,0);
        fond2.rotation.y = Math.PI / 2;
        scene.add(fond2);

        /* Fond côté droit */
        var fond3 = new THREE.Mesh(fondGeometry2, fondTexture);
        fond3.position.set(400,-610,0);
        fond3.rotation.y = Math.PI / 2;
        scene.add(fond3);

        /* Fond horizontal */
        var fondTexture2 = new THREE.MeshBasicMaterial({color:"#8B744B", side: THREE.DoubleSide});
        var fondGeometry3 = new THREE.PlaneBufferGeometry(800,500);
        var fond4 = new THREE.Mesh(fondGeometry3, fondTexture2);
        fond4.position.set(0,-1220,0);
        fond4.rotation.x = Math.PI / 2;
        scene.add(fond4);

        /* Coins verticaux gauche et droit */
        var coinTexture = new THREE.MeshBasicMaterial({color:"rgb(0,0,0)",wireframe:false});
        var coinGeometry1 = new THREE.CylinderGeometry(6/2, 6/2, 1220, 8, 1); 

        var coin1 = new THREE.Mesh(coinGeometry1, coinTexture);
        coin1.position.set(-400,-610,-250);
        scene.add(coin1);

        var coin2 = new THREE.Mesh(coinGeometry1, coinTexture);
        coin2.position.set(400,-610,-250);
        scene.add(coin2);

        /* Coins horizontaux gauche et droit */
        var coinGeometry2 = new THREE.CylinderGeometry(6/2, 6/2, 500, 8, 1);
        var coin2 = new THREE.Mesh(coinGeometry2, coinTexture);
        coin2.position.set(-400,-1220,0);
        coin2.rotation.x = Math.PI / 2;
        scene.add(coin2);

        var coin3 = new THREE.Mesh(coinGeometry2, coinTexture);
        coin3.position.set(400,-1220,0);
        coin3.rotation.x = Math.PI / 2;
        scene.add(coin3);

        /* Coin fond horizontal */
        var coinGeometry3 = new THREE.CylinderGeometry(6/2, 6/2, 800, 8, 1); 
        var coin4 = new THREE.Mesh(coinGeometry3, coinTexture);
        coin4.position.set(0,-1220,-250);
        coin4.rotation.z = Math.PI / 2;
        scene.add(coin4);

        /* Coin GTE */
        var coinGeometry4 = new THREE.CylinderGeometry(6/2, 6/2, 210, 8, 1);
        var coin5 = new THREE.Mesh(coinGeometry4, coinTexture);
        coin5.position.set(500,105,250);
        scene.add(coin5);

        /* Jonction des sondes en bas */
        var jonctionTexture = new THREE.MeshBasicMaterial({ color:"rgb(255,255,255)", wireframe:false });
        var jonctionGeometry = new THREE.CylinderGeometry(6/2, 6/2, 30, 8, 1);
        var jonction1 = new THREE.Mesh(jonctionGeometry, jonctionTexture);
        jonction1.position.set(-190,-700,110);
        jonction1.rotation.x = Math.PI / 2;
        jonction1.rotation.z = - Math.PI / 4;
        scene.add(jonction1);

        var jonction2 = new THREE.Mesh(jonctionGeometry, jonctionTexture);
        jonction2.position.set(-210,-700,130);
        jonction2.rotation.x = Math.PI / 2;
        jonction2.rotation.z = - Math.PI / 4;
        scene.add(jonction2);

        var jonction3 =  new THREE.Mesh(jonctionGeometry, jonctionTexture);
        jonction3.position.set(-70, -700, -190);
        jonction3.rotation.x = Math.PI / 2;
        jonction3.rotation.z = - Math.PI / 4;
        scene.add(jonction3);

        var jonction4 =  new THREE.Mesh(jonctionGeometry, jonctionTexture);
        jonction4.position.set(-90, -700, -170);
        jonction4.rotation.x = Math.PI / 2;
        jonction4.rotation.z = - Math.PI / 4;
        scene.add(jonction4);

        var jonction5 =  new THREE.Mesh(jonctionGeometry, jonctionTexture);
        jonction5.position.set(210, -800, 110);
        jonction5.rotation.x = Math.PI / 2;
        jonction5.rotation.z = - Math.PI / 4;
        scene.add(jonction5);

        var jonction6 =  new THREE.Mesh(jonctionGeometry, jonctionTexture);
        jonction6.position.set(190, -800, 130);
        jonction6.rotation.x = Math.PI / 2;
        jonction6.rotation.z = - Math.PI / 4;
        scene.add(jonction6);

        if (Detector.webgl) {
          renderer = new THREE.WebGLRenderer({ antialias:true });
        }
        else {
          renderer = new THREE.CanvasRenderer(); 
        }
        renderer.setClearColor(0xEDEDED);
        renderer.setPixelRatio(window.devicePixelRatio);
        renderer.setSize(window.innerWidth, window.innerHeight);
        container.appendChild(renderer.domElement);

        window.addEventListener('resize', onWindowResize, false);
        document.addEventListener('mousedown', onDocumentMouseDown , false);
        document.addEventListener('mousemove', onDocumentMouseMove, false);
      }

      function onWindowResize() {
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
      }

      function onDocumentMouseMove(event) {
        label.style.left = (event.clientX + 2) + 'px';
        label.style.top = (event.clientY - label.offsetHeight - 2) + 'px';
        mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
        mouse.y = - (event.clientY / window.innerHeight) * 2 + 1;
      }

      function onDocumentMouseDown(event) {
        event.preventDefault();

        mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
        mouse.y = - (event.clientY / window.innerHeight) * 2 + 1;

        raycaster.setFromCamera(mouse, camera);
        var intersects = raycaster.intersectObjects(targetList);
        if (intersects.length > 0) {
          // si la sonde est déjà sélectionnée
          if (intersects[0].object.name in selected) {
            var sondecolor = selected[intersects[0].object.name];
            intersects[0].object.material = sondecolor[0];
            delete selected[intersects[0].object.name];
            notifySondeDeleted(intersects[0].object.name, intersects[0].object.idC);
          } else {
            selected[intersects[0].object.name] = [intersects[0].object.material];
            intersects[0].object.material = new THREE.MeshBasicMaterial({color:"#DD2A2F"});
            notifySondeSelected(intersects[0].object.name, intersects[0].object.idC);
          }
        }
      }

      function animate() {
        requestAnimationFrame(animate);
        controls.update();
        render();
        update();
      }

      function render() {
        renderer.render(scene, camera);
      }

      function update() {
        raycaster.setFromCamera(mouse, camera);
        var intersects = raycaster.intersectObjects(targetList);
        if (intersects.length > 0) {
          if (intersects[0].object.name != labelIntersected) {
            label.innerHTML = intersects[0].object.name;
            labelIntersected = intersects[0].object.name;
            label.style.visibility = "visible";
          }
        } else if (labelIntersected != "") {
          labelIntersected = "";
          label.style.visibility = "hidden";
        }
      }

      function notifySondeSelected(name, id) {
        window.parent.postMessage("selected:" + name + "," + id, "*");
      }

      function notifySondeDeleted(name, id) {
        window.parent.postMessage("deleted:" + name + "," + id, "*");
      }

      function reset() {
        controls.reset();
      }

      function zoomPlus(){
        controls.dollyIn(1.2);
      }

      function zoomMoins(){
        controls.dollyOut(1.2);
      }

    </script>

    <script src="../../assets/js/placer_sonde.js"></script>
    <?php include '../scripts/pos_sonde.php'; ?>
    <script src="../../assets/js/placer_capteur_sonde.js"></script>
    <?php include '../scripts/pos_capteur_sonde.php'; ?>
  </body>
</html>