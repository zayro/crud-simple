var app = angular.module('app', []);

app.controller('controlador', function($scope, $http, $httpParamSerializerJQLike) {

    app.directive('stringToNumber', function() {
        return {
            require: 'ngModel',
            link: function(scope, element, attrs, ngModel) {
                ngModel.$parsers.push(function(value) {
                    return '' + value;
                });
                ngModel.$formatters.push(function(value) {
                    return parseFloat(value);
                });
            }
        };
    });

    $scope.guardar = function($datos) {

        console.log('enviar datos:', $datos);

        $http({
            method: 'POST',
            url: './backend/guardar.php',
            data: $httpParamSerializerJQLike($datos),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function successCallback(response) {
            $scope.consultar();
            $scope.usuario = {};

        }, function errorCallback(response) {
            console.error(response);
        });
    };


    $scope.update = function($datos) {

        $scope.ActualizarDatos = $datos;
    };

    $scope.actualizar = function($datos) {

        console.info($datos);

        $http({
            method: 'POST',
            url: './backend/actualizar.php',
            data: $httpParamSerializerJQLike($datos),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function successCallback(response) {
            $scope.consultar();
        }, function errorCallback(response) {
            console.error(response);
        });
    };

    $scope.eliminar = function($id) {
        $http({
            method: 'POST',
            url: './backend/eliminar.php',
            data: "id=" + $id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function successCallback(response) {
            $scope.consultar();
        }, function errorCallback(response) {
            console.error(response);
        });
    };

    $scope.consultar = function() {
        $http({
            method: 'POST',
            url: './backend/consultar.php'
        }).then(function successCallback(response) {
            $scope.consulta = response.data;
            console.log('datos de consulta', $scope.consulta);
        }, function errorCallback(response) {
            console.error(response);
        });
    };

    $scope.consultar();
    $scope.usuario = {};




});