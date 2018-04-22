using UnityEngine;
using System.Collections;

public class CiaccoRandom
{

    private static int superSeed = 0;
    
    public CiaccoRandom()
    {

    }
    
    public void setSeed(int seed)
    {
        // seed can only be positive and seed range is [0 -> 9999998] seed=9999999 schould give the same as seed=0
        superSeed = Mathf.Abs(seed) % 9999999 + 1;
        // init for randomness fairness
        superSeed = (superSeed * 125) % 2796203;
        superSeed = (superSeed * 125) % 2796203;
        superSeed = (superSeed * 125) % 2796203;
        superSeed = (superSeed * 125) % 2796203;
        superSeed = (superSeed * 125) % 2796203;
        superSeed = (superSeed * 125) % 2796203;
        superSeed = (superSeed * 125) % 2796203;
        superSeed = (superSeed * 125) % 2796203;
        superSeed = (superSeed * 125) % 2796203;
    }
    
    public int getRand(int min, int max) // both included: getRand(0,1) will return 0s and 1s
    {
        superSeed = (superSeed * 125) % 2796203;
        return superSeed % (max - min + 1) + min;
    }
}
