# Just a simple way to build the MO files

%.po: bojo.pot
	msgmerge -Uq $@ $<

%.mo: %.po
	msgfmt -o $@ $<

all: $(subst .po,.mo, $(wildcard *.po))

clean:
	rm -f *.mo
