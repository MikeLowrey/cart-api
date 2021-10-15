describe('All Sites Avaible?', () => {
    before(() => {
        cy.log('It used the live database for this test!')
    });

    it('shows all sites?', () => {
        cy.visit('/', {
            failOnStatusCode: false
        }).contains('Products: 21');
        cy.visit('/products', {
            failOnStatusCode: false
        }).contains('Test');
        cy.visit('/cart', {
            failOnStatusCode: false
        }).contains('Checkout');
    });
});

describe('Add first Product on /product and check if still avaible on /cart', () => {
    describe('Go to /cart and check if Cart still 1', () => {
        it('click on the first product img item', () => {
            cy.visit('/products').get('section img').first().click();
            cy.get('*[class^="absolute ml-3 -top-3 text-xs bg-gray-500 text-white rounded px-1 text-center z-0"]')
                .first()
                .should('to.contain', 1);


            const cartSite = cy.visit('/cart', {
                failOnStatusCode: false
            });

            cartSite.get('*[class^="absolute ml-3 -top-3 text-xs bg-gray-500 text-white rounded px-1 text-center z-0"]')
                .should('to.contain', 1);
        });
    });

    after(() => {
        cy.log('bye cookie')
        cy.clearCookie('laravel_session')
    })
});