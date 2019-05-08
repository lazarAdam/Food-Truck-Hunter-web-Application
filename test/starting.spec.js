/*
*
* Making test using Mocha node.js testing frame work
*
* How install? Easiest to deal w/ varying dependencies - use NVM:
*
* 1)Download NVM: https://github.com/creationix/nvm
* 2) Use NVM to download Mocha 8.0
*   Generated package.json file - of dependencies to use mochax
*
* 3)Make a test.js file like below
* 4)Run command "mocha" from root directory -- mocha will auto-run tests
*
* 5)
*
*   Note - if have tested directory of tests -- need call command
*       "mocha ./test/**/
/* to test all the nested test files
*
* */

var assert = require('assert');

describe('Basic Mocha Test', function(){
    it('should throw errors', function (){
        assert.equal(3,3)
    })
});