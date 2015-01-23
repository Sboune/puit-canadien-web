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
        camera.position.z = 1150;
        camera.position.y = 200;

        controls = new THREE.OrbitControls( camera );
        controls.damping = 1;
        controls.zoomSpeed = 0.5;
        controls.addEventListener( 'change', render );

        scene = new THREE.Scene();

        var light = new THREE.PointLight(0xffffff);
        light.position.set(0, 250, 1000);
        scene.add(light);

        var floorGeometryArr = new THREE.PlaneBufferGeometry (1800/2, 420/2);
        var floorGeometry = new THREE.PlaneBufferGeometry (1800/2, 600/2);
        var wallGeometry = new THREE.PlaneBufferGeometry (600/2, 420/2);
        
        /* B32 */
        var textureB32 = THREE.ImageUtils.loadTexture('../../assets/images/B32.jpg');
        var B32Material = new THREE.MeshBasicMaterial({map: textureB32, side: THREE.DoubleSide});
        var B32Geometry = new THREE.PlaneBufferGeometry (1800/2, 420/2);
        var B32 = new THREE.Mesh(B32Geometry, B32Material);
        B32.position.set(0, 630/2-XOFFSET, 0);
        scene.add(B32);
        
        /* CAFET */
        var textureCafet = THREE.ImageUtils.loadTexture('../../assets/images/Cafet.jpg');
        var CafetMaterial = new THREE.MeshBasicMaterial({map: textureCafet, side:THREE.DoubleSide});
        var CafetGeometry = new THREE.PlaneBufferGeometry (600/2, 420/2);
        var Cafet = new THREE.Mesh(CafetGeometry, CafetMaterial);
        Cafet.position.set(900/2, 630/2-XOFFSET, 300/2);
        Cafet.rotation.y = -Math.PI / 2;
        scene.add(Cafet);
        
        /* GTE */
        var textureGTE = THREE.ImageUtils.loadTexture('../../assets/images/GTE.jpg');
        var GTEMaterial = new THREE.MeshBasicMaterial({map: textureGTE, side: THREE.DoubleSide});
        var GTEGeometry = new THREE.PlaneBufferGeometry (600/2, 420/2);
        var GTE = new THREE.Mesh(GTEGeometry, GTEMaterial);
        GTE.position.set(-900/2, 630/2-XOFFSET, 300/2);
        GTE.rotation.y = Math.PI / 2;
        scene.add(GTE); 
      
        // sol
        var groundMaterial = new THREE.MeshBasicMaterial({color:"rgb(127,221,76)", side: THREE.DoubleSide, transparent: true, opacity: 0.5}); //vert
        var floorMaterial = new THREE.MeshBasicMaterial({color:"#8B744B", side: THREE.DoubleSide}); //marron
        var floorTransMaterial = new THREE.MeshBasicMaterial({color:"#8B806C", side: THREE.DoubleSide}); //marron      transparent
        var floor = new THREE.Mesh(floorGeometry, groundMaterial);
        var fond = new THREE.Mesh(floorGeometry, floorMaterial);
        var arriere = new THREE.Mesh(floorGeometryArr, floorTransMaterial);
        floor.position.set(0, 420/2-XOFFSET, 300/2);
        floor.rotation.x = Math.PI / 2;
        scene.add(floor);
        fond.position.set(0, -XOFFSET, 300/2);
        fond.rotation.x = Math.PI / 2;
        scene.add(fond);
        arriere.position.set(0, 210/2-XOFFSET, 0);
        scene.add(arriere);
      
        var gauche = new THREE.Mesh(wallGeometry, floorTransMaterial);
        gauche.position.set(-900/2, 210/2-XOFFSET, 300/2);
        gauche.rotation.y = Math.PI / 2;
        scene.add(gauche);
        
        var droite = new THREE.Mesh(wallGeometry, floorTransMaterial);
        droite.position.set(900/2, 210/2-XOFFSET, 300/2);
        droite.rotation.y = Math.PI / 2;
        scene.add(droite);
        
        var Geo = new THREE.CylinderGeometry(6/2, 6/2, 420, 8, 1); 
        var Geo3 = new THREE.CylinderGeometry(6/2, 6/2, 900, 8, 1);
        var Geo4 = new THREE.CylinderGeometry(6/2, 6/2, 300, 8, 1); 
        var Mat = new THREE.MeshBasicMaterial({color:"rgb(0,0,0)",wireframe:false})

        // coins B32 Cafet
        var coin = new THREE.Mesh(Geo, Mat);
        coin.position.x = 900/2;
        coin.position.y = 420/2-XOFFSET;
        scene.add(coin);

        var coin2 = new THREE.Mesh(Geo, Mat);
        coin2.position.x = -900/2;
        coin2.position.y = 420/2-XOFFSET;
        scene.add(coin2);

        // coin fond horizontal
        var coin6 = new THREE.Mesh(Geo3, Mat);
        coin6.position.x = 0;
        coin6.position.y = -XOFFSET;
        coin6.rotation.z = Math.PI / 2;
        scene.add(coin6);

        // coins droite gauche fond
        var coin7 = new THREE.Mesh(Geo4, Mat);
        coin7.position.x = 450;
        coin7.position.y = -XOFFSET;
        coin7.position.z = 300/2;
        coin7.rotation.x = Math.PI / 2;
        scene.add(coin7);

        var coin8 = new THREE.Mesh(Geo4, Mat);
        coin8.position.x = -450;
        coin8.position.y = -XOFFSET;
        coin8.position.z = 300/2;
        coin8.rotation.x = Math.PI / 2;
        scene.add(coin8);
      
        /* VMC */
        var vmcMaterial = new THREE.MeshBasicMaterial({color: 0x111111, side:THREE.DoubleSide, transparent:true, opacity:0.5})
        var vmcGeometry = new THREE.PlaneBufferGeometry (200/2, 200/2, 6/2, 6/2);
        var vmch = new THREE.Mesh(vmcGeometry, vmcMaterial);
        vmch.position.set(-1000/2, 840/2-XOFFSET, 500/2);
        vmch.rotation.x = Math.PI / 2;
        vmch.name = "vmc";
        scene.add(vmch);
      
        var vmcarr = new THREE.Mesh(vmcGeometry, vmcMaterial);
        vmcarr.position.set(-1000/2, 740/2-XOFFSET, 400/2)
        vmcarr.name = "vmc";
        scene.add(vmcarr);
      
        var vmcb = new THREE.Mesh(vmcGeometry, vmcMaterial);
        vmcb.position.set(-1000/2, 640/2-XOFFSET, 500/2);
        vmcb.rotation.x = Math.PI / 2;
        vmcb.name = "vmc";
        scene.add(vmcb);

        var Geo2 = new THREE.CylinderGeometry(2, 2, 100, 8, 1);
        var coin3 = new THREE.Mesh(Geo2, Mat);
        coin3.position.x = -500.5;
        coin3.position.y = 418-XOFFSET;
        coin3.position.z = 200;
        coin3.rotation.z = Math.PI / 2;
        scene.add(coin3);
        var coin4 = new THREE.Mesh(Geo2, Mat);
        coin4.position.x = -500.5;
        coin4.position.y = 320-XOFFSET;
        coin4.position.z = 200;
        coin4.rotation.z = Math.PI / 2;
        scene.add(coin4);

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

    </script>

    <script src="../../assets/js/placer_corbeille.js"></script>
    <?php include '../scripts/pos_corbeille.php'; ?>
    <script src="../../assets/js/placer_sonde.js"></script>
    <?php include '../scripts/pos_sonde.php'; ?>
    <script src="../../assets/js/placer_puit.js"></script>

  </body>
</html>