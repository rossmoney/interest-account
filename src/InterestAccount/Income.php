<?php

namespace InterestAccount;

use GuzzleHttp\Client as GuzzleClient;

/**
 * Class that handles the fetching of the users income value from the API, providing helper function to check if the API has been called.
 * This must be done before the Income class is passed to the InterestAccount class (separation of concerns)
 */
class Income
{
    /** @var \GuzzleHttp\Client $guzzleClient API connection to use */
    private GuzzleClient $guzzleClient;

    /** @var float $income Income value in pence */
    protected float $income;
    /** @var bool $incomeKnown Income value is present for the user true/false  */
    protected bool $incomeKnown = false;

    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;

        $this->guzzleClient = new GuzzleClient([
            // Base URI is used with relative requests
            'base_uri' => 'http://example.com',
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);
    }

    public function overrideGuzzleClient(GuzzleClient $client): Income
    {
        $this->guzzleClient = $client;

        return $this;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return float the income value
     */
    public function getIncomeValue(): float
    {
        return $this->income;
    }

    /**
     * Helper to determine whether income is known, if not known a different rate is used
     */
    public function isIncomeKnown(): bool
    {
        return $this->incomeKnown;
    }

    /**
     * Function that does the heavy lifing to retrieve the values from the API, and set to variables
     * 
     * @param string $userId the userId UUID-v4
     * 
     * @return float the income value
     */
    public function fetchFromAPI(): float
    {
        if (empty($this->user->getId())) {
            return 0;
        }

        $response = $this->guzzleClient->get('/users/' . $this->user->getId());
        $user = json_decode((string) $response->getBody(), true);
        if (count($user) > 0) {
            if (isset($user['income'])) {
                $this->incomeKnown = true;
                $this->income = (float) $user['income'];
                return $this->income;
            }
        }
        $this->incomeKnown = false;
        $this->income = (float) 0;
        return 0;
    }
}
