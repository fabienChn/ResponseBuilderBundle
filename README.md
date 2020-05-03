# ResponseBuilderBundle

A response builder using the Transformers Design Pattern built on 
top of the fractal/transformer package and adapted for Symfony

## Use 

Put this into your AbstractController:

    /**
     * Transform the data into an api response
     *
     * @param $transformer : Transformer name as string or transformer instance
     * @return \fabienChn\ResponseBuilderBundle\Component\ResponseBuilder
     */
    protected function buildResponse($transformer): ResponseBuilder
    {
        return new ResponseBuilder($transformer);
    }

And use it this way in your controller:

    return $this->buildResponse(CompanyTransformer::class)
            ->item($company)
            ->parseIncludes(['taxRegime'])
            ->response(200);
            
The CompanyTransformer will have to extend AbstractTransformer and to contain at least a 
public transform method returning an array 
(the data representing the company that has to be sent as response)


*Check out fractals doc for more details: https://fractal.thephpleague.com/transformers/*