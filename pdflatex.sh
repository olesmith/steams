#!/bin/sh

/usr/bin/pdflatex -interaction nonstopmode -output-directory $1 $1/$2 > $1/latex.log  2>&1

