#include <stdio.h>
#include<stdlib.h>
#include<string.h>
#include<dirent.h>

void compareData(char *room, char *asset, char **unfoundChromebooks, int *index, FILE *stream) {
  char searchString[BUFSIZ] = {0};
  FILE *fp = fopen("Chromebook Mass Export.txt", "r");
  if(fp == NULL) {
    printf("COULD NOT OPEN OTHER FILE\n");
    return;
  }
  while(fgets(searchString, BUFSIZ, fp)) {
    char *orgUnit = strtok(searchString, ",");
    char *roomNote = strtok(NULL, ",");
    char *assetNote = strtok(NULL, ",");
    char *serialNumber = strtok(NULL, ",");
    char *model = strtok(NULL, ",");

    if(strncmp(asset, assetNote, 4) == 0) {
      fprintf(stream, "%s | %s | %s", assetNote, serialNumber, model);
      fclose(fp);
      return;
    }
  }
  *unfoundChromebooks = calloc(strlen(asset) + 1, sizeof(char));
  strcpy(*unfoundChromebooks, asset);
  (*index)++;
  fclose(fp);
}

int main() {
  int unfoundIndex = 0;
  char *unfoundChromebooks[BUFSIZ] = {0};
  DIR *path = opendir("Data");
  struct dirent *dp;
  FILE *writeFile = fopen("output.txt", "w");

  if(writeFile == NULL) {
    printf("COULD NOT OPEN OUTPUT FILE\n");
    return EXIT_FAILURE;
  }

  while((dp = readdir(path)) != NULL) {
    if(strcmp(dp->d_name, ".") == 0 || strcmp(dp->d_name, "..") == 0) {
      continue;
    }


    char string[BUFSIZ] = {0};



    char dirName[50] = "Data/";
    char fullPath[50] = {0};
    strcpy(fullPath, dirName);
    strcat(fullPath, dp->d_name);
    FILE *fp = fopen(fullPath, "r");
    if(fp == NULL) {
      printf("COULD NOT OPEN FILE %s\n", dp->d_name);
    }
    else {
      printf("SUCCESSFULLY OPENED FILE %s\n", dp->d_name);
    }

    while(fgets(string, BUFSIZ, fp)) {
      char *room = strtok(string, ",");
      char *asset = strtok(NULL, ",");
      compareData(room, asset, &unfoundChromebooks[unfoundIndex], &unfoundIndex, writeFile);
    }
    fclose(fp);

  }

  for(int i = 0; i < unfoundIndex; i++) {
    fprintf(writeFile, "COULD NOT FIND %s", unfoundChromebooks[i]);
  }

  for(int i = 0; i < unfoundIndex; i++) {
    free(unfoundChromebooks[i]);
  }
  fclose(writeFile);
  closedir(path);
  return EXIT_SUCCESS;

}
