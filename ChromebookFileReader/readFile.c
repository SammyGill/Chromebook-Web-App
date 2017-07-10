#include <stdio.h>
#include<stdlib.h>
#include<string.h>
#include<dirent.h>

void compareData(char *room, char *asset, char *unfoundChromebooks, int *index) {
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
      printf("%s | %s | %s", assetNote, serialNumber, model);
      fclose(fp);
      return;
    }
  }
  strcpy(unfoundChromebooks, asset);
  (*index)++;
  //printf("COULD NOT FIND %s", asset);
  fclose(fp);
}

int main() {
  DIR *path = opendir("data");
  struct dirent *dp;

  while((dp = readdir(path)) != NULL) {
    if(strcmp(dp->d_name, ".") == 0 || strcmp(dp->d_name, "..") == 0) {
      continue;
    }

    int unfoundIndex = 0;
    char string[BUFSIZ] = {0};
    char *unfoundChromebooks[BUFSIZ];


    char dirName[50] = "Data/";
    char fullPath[50];
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
      unfoundChromebooks[unfoundIndex] = calloc(strlen(asset) + 1, sizeof(char));
      compareData(room, asset, unfoundChromebooks[unfoundIndex], &unfoundIndex);
    }

    for(int i = 0; i < unfoundIndex; i++) {
      printf("COULD NOT FIND %s", unfoundChromebooks[i]);
    }
  }

  return 0;

}
