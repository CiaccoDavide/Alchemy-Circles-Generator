using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public static class TextureDraw
{
    public static void drawLine(Texture2D tex, int x0, int y0, int x1, int y1, Color col, int thickness)
    {
        int dx, dy, incr1, incr2, d, x, y, xend, yend, xdirflag, ydirflag;
        int wid;
        int w, wstart;

        dx = Mathf.Abs(x1 - x0);
        dy = Mathf.Abs(y1 - y0);

        if (dx == 0)
        {
            gdImageVLine(tex, x0, y0, y1, col, thickness);
            return;
        }
        else if (dy == 0)
        {
            gdImageHLine(tex, y0, x0, x1, col, thickness);
            return;
        }

        if (dy <= dx)
        {
            double ac = Mathf.Cos(Mathf.Atan2(dy, dx));
            if (ac != 0)
            {
                wid = (int)(thickness / ac);
            }
            else
            {
                wid = 1;
            }
            if (wid == 0)
            {
                wid = 1;
            }
            d = 2 * dy - dx;
            incr1 = 2 * dy;
            incr2 = 2 * (dy - dx);
            if (x0 > x1)
            {
                x = x1;
                y = y1;
                ydirflag = (-1);
                xend = x0;
            }
            else
            {
                x = x0;
                y = y0;
                ydirflag = 1;
                xend = x1;
            }

            /* Set up line thickness */
            wstart = y - wid / 2;
            for (w = wstart; w < wstart + wid; w++)
                tex.SetPixel(x, w, col);

            if (((y1 - y0) * ydirflag) > 0)
            {
                while (x < xend)
                {
                    x++;
                    if (d < 0)
                    {
                        d += incr1;
                    }
                    else
                    {
                        y++;
                        d += incr2;
                    }
                    wstart = y - wid / 2;
                    for (w = wstart; w < wstart + wid; w++)
                        tex.SetPixel(x, w, col);
                }
            }
            else
            {
                while (x < xend)
                {
                    x++;
                    if (d < 0)
                    {
                        d += incr1;
                    }
                    else
                    {
                        y--;
                        d += incr2;
                    }
                    wstart = y - wid / 2;
                    for (w = wstart; w < wstart + wid; w++)
                        tex.SetPixel(x, w, col);
                }
            }
        }
        else
        {
            double ass = Mathf.Sin(Mathf.Atan2(dy, dx));
            if (ass != 0)
            {
                wid = (int)(thickness / ass);
            }
            else
            {
                wid = 1;
            }
            if (wid == 0)
                wid = 1;

            d = 2 * dx - dy;
            incr1 = 2 * dx;
            incr2 = 2 * (dx - dy);
            if (y0 > y1)
            {
                y = y1;
                x = x1;
                yend = y0;
                xdirflag = (-1);
            }
            else
            {
                y = y0;
                x = x0;
                yend = y1;
                xdirflag = 1;
            }

            /* Set up line thickness */
            wstart = x - wid / 2;
            for (w = wstart; w < wstart + wid; w++)
                tex.SetPixel(w, y, col);

            if (((x1 - x0) * xdirflag) > 0)
            {
                while (y < yend)
                {
                    y++;
                    if (d < 0)
                    {
                        d += incr1;
                    }
                    else
                    {
                        x++;
                        d += incr2;
                    }
                    wstart = x - wid / 2;
                    for (w = wstart; w < wstart + wid; w++)
                        tex.SetPixel(w, y, col);
                }
            }
            else
            {
                while (y < yend)
                {
                    y++;
                    if (d < 0)
                    {
                        d += incr1;
                    }
                    else
                    {
                        x--;
                        d += incr2;
                    }
                    wstart = x - wid / 2;
                    for (w = wstart; w < wstart + wid; w++)
                        tex.SetPixel(w, y, col);
                }
            }
        }

    }




    static void gdImageHLine(Texture2D tex, int y, int x1, int x2, Color col, int thickness)
    {
        if (thickness > 1)
        {
            int thickhalf = thickness >> 1;
            _gdImageFilledHRectangle(tex, x1, y - thickhalf, x2, y + thickness - thickhalf - 1, col);
        }
        else
        {
            if (x2 < x1)
            {
                int t = x2;
                x2 = x1;
                x1 = t;
            }

            for (; x1 <= x2; x1++)
            {
                tex.SetPixel(x1, y, col);
            }
        }
        return;
    }

    static void gdImageVLine(Texture2D tex, int x, int y1, int y2, Color col, int thickness)
    {
        if (thickness > 1)
        {
            int thickhalf = thickness >> 1;
            _gdImageFilledVRectangle(tex, x - thickhalf, y1, x + thickness - thickhalf - 1, y2, col);
        }
        else
        {
            if (y2 < y1)
            {
                int t = y1;
                y1 = y2;
                y2 = t;
            }

            for (; y1 <= y2; y1++)
            {
                tex.SetPixel(x, y1, col);
            }
        }
        return;
    }


    static void _gdImageFilledHRectangle(Texture2D tex, int x1, int y1, int x2, int y2, Color col)
    {
        int x, y;

        if (x1 == x2 && y1 == y2)
        {
            tex.SetPixel(x1, y1, col);
            return;
        }

        if (x1 > x2)
        {
            x = x1;
            x1 = x2;
            x2 = x;
        }

        if (y1 > y2)
        {
            y = y1;
            y1 = y2;
            y2 = y;
        }

        if (x1 < 0)
        {
            x1 = 0;
        }

        if (x2 >= tex.width)
        {
            x2 = tex.width - 1;
        }

        if (y1 < 0)
        {
            y1 = 0;
        }

        if (y2 >= tex.height)
        {
            y2 = tex.height - 1;
        }

        for (x = x1; (x <= x2); x++)
        {
            for (y = y1; (y <= y2); y++)
            {
                tex.SetPixel(x, y, col);
            }
        }
    }

    static void _gdImageFilledVRectangle(Texture2D tex, int x1, int y1, int x2, int y2, Color col)
    {
        int x, y;

        if (x1 == x2 && y1 == y2)
        {
            tex.SetPixel(x1, y1, col);
            return;
        }

        if (x1 > x2)
        {
            x = x1;
            x1 = x2;
            x2 = x;
        }

        if (y1 > y2)
        {
            y = y1;
            y1 = y2;
            y2 = y;
        }

        if (x1 < 0)
        {
            x1 = 0;
        }

        if (x2 >= tex.width)
        {
            x2 = tex.width - 1;
        }

        if (y1 < 0)
        {
            y1 = 0;
        }

        if (y2 >= tex.height)
        {
            y2 = tex.height - 1;
        }

        for (y = y1; (y <= y2); y++)
        {
            for (x = x1; (x <= x2); x++)
            {
                tex.SetPixel(x, y, col);
            }
        }
    }


















    public static void drawCircle(Texture2D tex, int cx, int cy, int r, Color col, int thickness)
    {
        //int y = r;
        //float d = 1 / 4 - r;
        //float end = Mathf.Ceil(r / Mathf.Sqrt(2));

        //for (int x = 0; x <= end; x++)
        //{
        //    tex.SetPixel(cx + x, cy + y, col);
        //    tex.SetPixel(cx + x, cy - y, col);
        //    tex.SetPixel(cx - x, cy + y, col);
        //    tex.SetPixel(cx - x, cy - y, col);
        //    tex.SetPixel(cx + y, cy + x, col);
        //    tex.SetPixel(cx - y, cy + x, col);
        //    tex.SetPixel(cx + y, cy - x, col);
        //    tex.SetPixel(cx - y, cy - x, col);

        //    d += 2 * x + 1;
        //    if (d > 0)
        //    {
        //        d += 2 - 2 * y--;
        //    }
        //}
        for (int asd = 0; asd < thickness; asd++)
        {
            for (double i = 0.0; i < 360.0; i += 0.5)
            {
                double angle = i * System.Math.PI / 180;
                int x = (int)(cx + r * System.Math.Cos(angle));
                int y = (int)(cy + r * System.Math.Sin(angle));
                tex.SetPixel(x, y, col);
            }
            r++;
        }
    }
    public static void drawFilledCircle(Texture2D tex, int cx, int cy, int r, Color col, Color bgcol,int thickness)
    {
        for (int x = -r; x < r; x++)
        {
            int height = (int)Mathf.Sqrt(r * r - x * x);

            for (int y = -height; y < height; y++)
                tex.SetPixel(x + cx, y + cy, bgcol);
        }

        drawCircle(tex, cx, cy, r, col, thickness);
    }



    private static Vector2[] getPoints(int sides, float rot, float radius, float size)
    {
        Vector2[] values = new Vector2[sides];
        float angdiff = Mathf.Deg2Rad * (360 / (sides));
        rot = Mathf.Deg2Rad * (rot);
        for (int i = 0; i < sides; i++)
        {
            // trova i punti sulla circonferenza
            values[i].x = (size / 2) + radius * Mathf.Cos(i * angdiff + rot); // X
            values[i].y = (size / 2) + radius * Mathf.Sin((i) * angdiff + rot); // Y
        }

        return values;
    }

    public static void drawPolygon(Texture2D tex, int n, int r, int rot, int size, Color col, int thickness)
    {
        if (n <= 0)
        {
            return;
        }

        Vector2[] p = getPoints(n, rot, r, size);

        int i = 0;

        drawLine(tex, (int)p[i].x, (int)p[i].y, (int)p[n - 1].x, (int)p[n - 1].y, col, thickness);

        for (i = 1; (i < n); i++)
        {
            drawLine(tex, (int)p[i - 1].x, (int)p[i - 1].y, (int)p[i].x, (int)p[i].y, col, thickness);
        }

    }



    public static void drawFilledPolygon(Texture2D tex, int n, int r,int rot, int size, Color color, Color backgroundColor, int thickness)
    {

        Vector2[] p = getPoints(n, rot, r, size);

        int i;
        int j;
        int index;
        int y;
        int miny, maxy, pmaxy;
        int x1, y1;
        int x2, y2;
        int ind1, ind2;
        int ints;
        int fill_color;
        if (n <= 0)
        {
            return;
        }

        miny = (int)p[0].y;
        maxy = (int)p[0].y;
        for (i = 1; (i < n); i++)
        {
            if (p[i].y < miny)
            {
                miny = (int)p[i].y;
            }
            if (p[i].y > maxy)
            {
                maxy = (int)p[i].y;
            }
        }
        /* necessary special case: horizontal line */
        if (n > 1 && miny == maxy)
        {
            x1 = x2 = (int)p[0].x;
            for (i = 1; (i < n); i++)
            {
                if (p[i].x < x1)
                {
                    x1 = (int)p[i].x;
                }
                else if (p[i].x > x2)
                {
                    x2 = (int)p[i].x;
                }
            }
            drawLine(tex, x1, miny, x2, miny, backgroundColor, thickness);
            return;
        }
        pmaxy = maxy;

        // keep this inside the texture
        if (miny < 0)
        {
            miny = 0;
        }
        if (maxy > tex.height - 1)
        {
            maxy = tex.height - 1;
        }
        /* Fix in 1.3: count a vertex only once */
        for (y = miny; (y <= maxy); y++)
        {
            ints = 0;
            int[] polyInts = new int[n];
            for (i = 0; (i < n); i++)
            {
                if (i == 0)
                {
                    ind1 = n - 1;
                    ind2 = 0;
                }
                else
                {
                    ind1 = i - 1;
                    ind2 = i;
                }
                y1 = (int)p[ind1].y;
                y2 = (int)p[ind2].y;
                if (y1 < y2)
                {
                    x1 = (int)p[ind1].x;
                    x2 = (int)p[ind2].x;
                }
                else if (y1 > y2)
                {
                    y2 = (int)p[ind1].y;
                    y1 = (int)p[ind2].y;
                    x2 = (int)p[ind1].x;
                    x1 = (int)p[ind2].x;
                }
                else
                {
                    continue;
                }
                /* Do the following math as float intermediately, and round to ensure
                 * that Polygon and FilledPolygon for the same set of points have the
                 * same footprint. */

                if ((y >= y1) && (y < y2))
                {
                    polyInts[ints++] = (int)((float)((y - y1) * (x2 - x1)) /
                                                  (float)(y2 - y1) + 0.5 + x1);
                }
                else if ((y == pmaxy) && (y == y2))
                {
                    polyInts[ints++] = x2;
                }
            }


            // 2.0.26: polygons pretty much always have less than 100 points, and most of the time they have considerably less. For such trivial cases, insertion sort is a good choice. Also a good choice for future implementations that may wish to indirect through a table.

            for (i = 1; (i < ints); i++)
            {
                index = polyInts[i];
                j = i;
                while ((j > 0) && (polyInts[j - 1] > index))
                {
                    polyInts[j] = polyInts[j - 1];
                    j--;
                }
                polyInts[j] = index;
            }
            for (i = 0; (i < (ints - 1)); i += 2)
            {
                // 2.0.29: back to gdImageLine to prevent segfaults when performing a pattern fill
                drawLine(tex, polyInts[i], y, polyInts[i + 1], y, backgroundColor,thickness);
            }
        }

        // draw border
        drawPolygon(tex, n, r, rot, size, color, thickness);

    }

}
