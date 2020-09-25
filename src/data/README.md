# :file_folder: The `data/` folder

The `data/` folder contains all the data of the application, i.e.
- `user.json` for userdata,
- `bookData.json` for all information about book note files and
- two subfolders, `data/books/` and `data/covers/`, containing all the book note data:
	- `data/books/` stores all book note data in markdown (`.md`) format and
	- `data/covers/` stores all book covers in JPEG (`.jpg`) format.

Note that no matter how many users there are, all of those users share the same `data/` folder, i.e., the idea is that all users share the same library of book notes.

## :pencil: Adding new notes

In order to add a new book note file, simply put that `.md` file into the `data/books/` subfolder and you are ready to go. The user interface of this application provides a 'Refresh database' button to include new files into the user interface. The book note files should follow a given structure, for more information on this see below.

In case you want to upload a corresponding cover file for some book, simply put that cover file into the `data/covers/` subfolder and give it the same name as the book note `.md` file. The optimal image size is 240x360 pixels.

### Markdown structure

The book note markdown files should follow a given structure in order to be rendered correctly. This structure looks as follows:

```md
# Title of the book - Author of the book

> 01.09.2020, eBook  
> 22.09.2020, Paperback

> Category 1  
> Category 2  
> Category 3

---
Here comes the actual content of the book note file (arbitrary markdown syntax).
```

The top part of the file is the important one - everything below `---` is rendered as actual content. Hence, the `---` marker should not be missing.

The first line contains a `#` heading including title and author of the book, separated by ` - ` (with spaces before and after that character).

After an empty line, there are arbitrary many lines containing dates when the book was read, formatted as `> dd.mm.yyyy, format` for each line. `format` gives the format in which the book was read, e.g. `eBook`, `paperback`, etc.

After another empty line, there are categories for that book, written down as `> Category name` per line.

And that's it! Just remember to put the marker `---` with a preceding empty line after the categories, before the actual content begins.

The format was chosen such that the markdown file is legible when being opened with an arbitrary markdown editor.