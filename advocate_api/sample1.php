<link rel="stylesheet" type="text/css" href='https://cdn.gitcdn.link/cdn/angular/bower-material/v1.1.12/angular-material.css'>
<link rel="stylesheet" type="text/css" href='https://material.angularjs.org/1.1.12/docs.css'>
<script type="text/javascript" src='https://ajax.googleapis.com/ajax/libs/angularjs/1.7.5/angular.js'></script>
<script type="text/javascript" src='https://ajax.googleapis.com/ajax/libs/angularjs/1.7.5/angular-animate.min.js'></script>
<script type="text/javascript" src='https://ajax.googleapis.com/ajax/libs/angularjs/1.7.5/angular-route.min.js'></script>
<script type="text/javascript" src='https://ajax.googleapis.com/ajax/libs/angularjs/1.7.5/angular-aria.min.js'></script>
<script type="text/javascript" src='https://ajax.googleapis.com/ajax/libs/angularjs/1.7.5/angular-messages.min.js'></script>
<script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.js'></script>
<script type="text/javascript" src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/t-114/svg-assets-cache.js'></script>
<script type="text/javascript" src='https://cdn.gitcdn.link/cdn/angular/bower-material/v1.1.12/angular-material.js'></script>




<div ng-controller="DemoCtrl as ctrl" layout="column" ng-cloak="" class="autocompletedemoBasicUsage" ng-app="MyApp">
  <md-content class="md-padding">
    <form ng-submit="$event.preventDefault()">
      <p id="autocompleteDescription">
        Use <code>md-autocomplete</code> to search for matches from local or remote data sources.
      </p>
      <label id="favoriteStateLabel">Favorite State</label>
      <md-autocomplete ng-disabled="ctrl.isDisabled" md-no-cache="ctrl.noCache" md-selected-item="ctrl.selectedItem" md-search-text-change="ctrl.searchTextChange(ctrl.searchText)" md-search-text="ctrl.searchText" md-selected-item-change="ctrl.selectedItemChange(item)" md-items="item in ctrl.querySearch(ctrl.searchText)" md-item-text="item.display" md-min-length="0" placeholder="Ex. Alaska" input-aria-labelledby="favoriteStateLabel" input-aria-describedby="autocompleteDetailedDescription">
        <md-item-template>
          <span md-highlight-text="ctrl.searchText" md-highlight-flags="^i">{{item.display}}</span>
        </md-item-template>
        <md-not-found>
          No states matching "{{ctrl.searchText}}" were found.
          <a ng-click="ctrl.newState(ctrl.searchText)">Create a new one!</a>
        </md-not-found>
      </md-autocomplete>
      <br>
      <md-checkbox ng-model="ctrl.noCache">Disable caching of queries?</md-checkbox>
    </form>
  </md-content>
</div>

<script>
(function () {
  'use strict';
  angular
      .module('MyApp', ['ngMaterial', 'ngMessages', 'material.svgAssetsCache'])
      .controller('DemoCtrl', DemoCtrl);

  function DemoCtrl ($timeout, $q, $log) {
    var self = this;

    self.simulateQuery = false;
    self.isDisabled    = false;

    // list of `state` value/display objects
    self.states        = loadAll();
    self.querySearch   = querySearch;
    self.selectedItemChange = selectedItemChange;
    self.searchTextChange   = searchTextChange;

    self.newState = newState;

    function newState(state) {
      alert("Sorry! You'll need to create a Constitution for " + state + " first!");
    }

    // ******************************
    // Internal methods
    // ******************************

    /**
     * Search for states... use $timeout to simulate
     * remote dataservice call.
     */
    function querySearch (query) {
      var results = query ? self.states.filter( createFilterFor(query) ) : self.states,
          deferred;
      if (self.simulateQuery) {
        deferred = $q.defer();
        $timeout(function () { deferred.resolve( results ); }, Math.random() * 1000, false);
        return deferred.promise;
      } else {
        return results;
      }
    }

    function searchTextChange(text) {
      $log.info('Text changed to ' + text);
    }

    function selectedItemChange(item) {
      $log.info('Item changed to ' + JSON.stringify(item));
    }

    /**
     * Build `states` list of key/value pairs
     */
    function loadAll() {
      var allStates = 'Alabama, Alaska, Arizona, Arkansas, California, Colorado, Connecticut, Delaware,\
              Florida, Georgia, Hawaii, Idaho, Illinois, Indiana, Iowa, Kansas, Kentucky, Louisiana,\
              Maine, Maryland, Massachusetts, Michigan, Minnesota, Mississippi, Missouri, Montana,\
              Nebraska, Nevada, New Hampshire, New Jersey, New Mexico, New York, North Carolina,\
              North Dakota, Ohio, Oklahoma, Oregon, Pennsylvania, Rhode Island, South Carolina,\
              South Dakota, Tennessee, Texas, Utah, Vermont, Virginia, Washington, West Virginia,\
              Wisconsin, Wyoming';

      return allStates.split(/, +/g).map( function (state) {
        return {
          value: state.toLowerCase(),
          display: state
        };
      });
    }

    /**
     * Create filter function for a query string
     */
    function createFilterFor(query) {
      var lowercaseQuery = query.toLowerCase();

      return function filterFn(state) {
        return (state.value.indexOf(lowercaseQuery) === 0);
      };

    }
  }
})();
</script>