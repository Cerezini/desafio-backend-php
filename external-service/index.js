const Hapi = require('hapi')

const port = 8001 

const app = new Hapi.Server({ port })

async function main() {

    app.route([{
        path: '/transaction',
        method: 'GET',
        handler: (request, h) => {
            const { value } = request.query
            
            let transactionValue = Number.parseFloat(value)

            if (transactionValue > 0 && transactionValue < 100) {
                return {}
            }
            
            return h.response().code(401)
        }
    }])

    await app.start()
    console.log('Server running on port ', app.info.port)
}

main()